<?php

namespace Modules\Ecommerce\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function download(Order $order)
    {
        // Ensure user can only download their own invoices
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['items.product.merchant', 'user']);

        $pdf = Pdf::loadView('ecommerce::invoices.order', compact('order'));
        
        return $pdf->download('invoice-' . $order->order_number . '.pdf');
    }

    public function view(Order $order)
    {
        // Ensure user can only view their own invoices
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['items.product.merchant', 'user']);

        return view('ecommerce::invoices.order', compact('order'));
    }
}
