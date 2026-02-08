<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SSLCommerzService
{
    protected $storeId;
    protected $storePassword;
    protected $apiUrl;

    public function __construct()
    {
        $this->storeId = config('services.sslcommerz.store_id');
        $this->storePassword = config('services.sslcommerz.store_password');
        $this->apiUrl = config('services.sslcommerz.api_url', 'https://sandbox.sslcommerz.com');
    }

    /**
     * Initialize payment session
     *
     * @param array $orderData
     * @return array
     */
    public function initiatePayment(array $orderData): array
    {
        $postData = [
            'store_id' => $this->storeId,
            'store_passwd' => $this->storePassword,
            'total_amount' => $orderData['amount'],
            'currency' => 'BDT',
            'tran_id' => $orderData['transaction_id'],
            'success_url' => route('payment.success'),
            'fail_url' => route('payment.fail'),
            'cancel_url' => route('payment.cancel'),
            'ipn_url' => route('payment.ipn'),
            
            // Customer information
            'cus_name' => $orderData['customer_name'],
            'cus_email' => $orderData['customer_email'],
            'cus_add1' => $orderData['customer_address'],
            'cus_city' => $orderData['customer_city'] ?? 'Dhaka',
            'cus_postcode' => $orderData['customer_postcode'] ?? '1000',
            'cus_country' => 'Bangladesh',
            'cus_phone' => $orderData['customer_phone'],
            
            // Product information
            'product_name' => $orderData['product_name'] ?? 'Order Payment',
            'product_category' => $orderData['product_category'] ?? 'General',
            'product_profile' => 'general',
            
            // Shipment information
            'shipping_method' => 'YES',
            'num_of_item' => $orderData['num_of_items'] ?? 1,
        ];

        $response = Http::asForm()->post($this->apiUrl . '/gwprocess/v4/api.php', $postData);

        if ($response->successful()) {
            $data = $response->json();
            
            if ($data['status'] === 'SUCCESS') {
                return [
                    'success' => true,
                    'gateway_url' => $data['GatewayPageURL'],
                    'session_key' => $data['sessionkey'],
                ];
            }
        }

        return [
            'success' => false,
            'message' => 'Payment initialization failed',
        ];
    }

    /**
     * Validate payment
     *
     * @param string $transactionId
     * @param string $amount
     * @param string $currency
     * @return bool
     */
    public function validatePayment(string $transactionId, string $amount, string $currency = 'BDT'): bool
    {
        $validationUrl = $this->apiUrl . '/validator/api/validationserverAPI.php';
        
        $params = [
            'val_id' => request('val_id'),
            'store_id' => $this->storeId,
            'store_passwd' => $this->storePassword,
            'format' => 'json',
        ];

        $response = Http::get($validationUrl, $params);

        if ($response->successful()) {
            $data = $response->json();
            
            if ($data['status'] === 'VALID' || $data['status'] === 'VALIDATED') {
                // Verify transaction details
                if ($data['tran_id'] === $transactionId && 
                    $data['amount'] == $amount && 
                    $data['currency'] === $currency) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Refund transaction
     *
     * @param string $bankTransactionId
     * @param float $refundAmount
     * @param string $refundRemarks
     * @return array
     */
    public function refundTransaction(string $bankTransactionId, float $refundAmount, string $refundRemarks = ''): array
    {
        $refundUrl = $this->apiUrl . '/validator/api/merchantTransIDvalidationAPI.php';
        
        $params = [
            'refund_amount' => $refundAmount,
            'refund_remarks' => $refundRemarks,
            'bank_tran_id' => $bankTransactionId,
            'store_id' => $this->storeId,
            'store_passwd' => $this->storePassword,
            'format' => 'json',
        ];

        $response = Http::get($refundUrl, $params);

        if ($response->successful()) {
            return $response->json();
        }

        return [
            'status' => 'failed',
            'message' => 'Refund request failed',
        ];
    }
}
