<?php

namespace Modules\Ecommerce\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Order;
use App\Models\Payment;
use App\Services\SSLCommerzService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    protected $sslCommerz;

    public function __construct(SSLCommerzService $sslCommerz)
    {
        $this->sslCommerz = $sslCommerz;
    }

    /**
     * Initiate payment
     */
    public function initiate(Request $request)
    {
        $order = Order::findOrFail($request->order_id);

        // Ensure user owns the order
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Generate transaction ID
        $transactionId = 'TXN' . time() . rand(1000, 9999);

        // Create payment record
        $payment = Payment::create([
            'order_id' => $order->id,
            'user_id' => auth()->id(),
            'transaction_id' => $transactionId,
            'amount' => $order->total_amount,
            'payment_method' => 'sslcommerz',
            'status' => 'pending',
        ]);

        // Prepare order data for SSLCommerz
        $orderData = [
            'transaction_id' => $transactionId,
            'amount' => $order->total_amount,
            'customer_name' => $order->user->name,
            'customer_email' => $order->user->email ?? 'customer@cmarket.com',
            'customer_phone' => $order->phone,
            'customer_address' => $order->shipping_address,
            'product_name' => 'Order #' . $order->order_number,
            'num_of_items' => $order->items->count(),
        ];

        // Initialize payment
        $result = $this->sslCommerz->initiatePayment($orderData);

        if ($result['success']) {
            // Redirect to payment gateway
            return redirect($result['gateway_url']);
        }

        return redirect()->route('checkout.index')
            ->with('error', 'Payment initialization failed. Please try again.');
    }

    /**
     * Payment success callback
     */
    public function success(Request $request)
    {
        $transactionId = $request->tran_id;
        $amount = $request->amount;

        // Validate payment
        if ($this->sslCommerz->validatePayment($transactionId, $amount)) {
            DB::beginTransaction();
            try {
                $payment = Payment::where('transaction_id', $transactionId)->first();

                if ($payment && $payment->status === 'pending') {
                    // Update payment status
                    $payment->update([
                        'status' => 'completed',
                        'gateway_response' => json_encode($request->all()),
                        'paid_at' => now(),
                    ]);

                    // Update order status
                    $payment->order->update([
                        'payment_status' => 'paid',
                        'status' => 'processing',
                    ]);

                    DB::commit();

                    return redirect()->route('orders.show', $payment->order)
                        ->with('success', 'Payment successful! Your order is being processed.');
                }
            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error('Payment success error: ' . $e->getMessage());
            }
        }

        return redirect()->route('orders.index')
            ->with('error', 'Payment verification failed.');
    }

    /**
     * Payment failed callback
     */
    public function fail(Request $request)
    {
        $transactionId = $request->tran_id;

        $payment = Payment::where('transaction_id', $transactionId)->first();

        if ($payment) {
            $payment->update([
                'status' => 'failed',
                'gateway_response' => json_encode($request->all()),
            ]);
        }

        return redirect()->route('checkout.index')
            ->with('error', 'Payment failed. Please try again.');
    }

    /**
     * Payment cancelled callback
     */
    public function cancel(Request $request)
    {
        $transactionId = $request->tran_id;

        $payment = Payment::where('transaction_id', $transactionId)->first();

        if ($payment) {
            $payment->update([
                'status' => 'cancelled',
                'gateway_response' => json_encode($request->all()),
            ]);
        }

        return redirect()->route('checkout.index')
            ->with('info', 'Payment cancelled.');
    }

    /**
     * IPN (Instant Payment Notification) callback
     */
    public function ipn(Request $request)
    {
        // Log IPN data for debugging
        \Log::info('SSLCommerz IPN:', $request->all());

        // Process IPN if needed
        // This is called by SSLCommerz server, not the user

        return response()->json(['status' => 'received']);
    }
}
