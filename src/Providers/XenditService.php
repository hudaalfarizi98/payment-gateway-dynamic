<?php

namespace PaymentGatewayManager\Providers;

use PaymentGatewayManager\Contracts\PaymentGatewayInterface;
use Xendit\Xendit;
use Xendit\Invoice;

class XenditService implements PaymentGatewayInterface
{
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
        Xendit::setApiKey($config['api_key']);
    }

    /**
     * Membuat transaksi Xendit (Simulasi)
     */
    public function createTransaction(array $data)
    {
        return json_encode(['message' => 'Xendit transaction created', 'data' => $data]);
    }

    /**
     * Membuat Payment Link (Invoice) Xendit
     */
    public function createPaymentLink(array $params)
    {
        try {
            $invoice = Invoice::create($params);
            return ['payment_link' => $invoice['invoice_url']];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Menangani callback dari Xendit
     */
    public function handleCallback(array $request)
    {
        return json_encode(['status' => 'handled', 'data' => $request]);
    }
}