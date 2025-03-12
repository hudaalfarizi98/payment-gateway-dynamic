<?php

namespace PaymentGatewayManager\Providers;

use PaymentGatewayManager\Contracts\PaymentGatewayInterface;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransService implements PaymentGatewayInterface
{
    protected $config;
    public function __construct(array $config)
    {
        $this->config = $config;

        Config::$serverKey = $config['server_key'];
        Config::$isProduction = $config['is_production'] ?? false;
        Config::$is3ds = $config['is_3ds'] ?? true;
    }

    public function createTransaction(array $data)
    {
        return Snap::getSnapToken($data);
    }

    /**
     * Membuat Payment Link (URL pembayaran untuk dikirim via email)
     */
    public function createPaymentLink(array $params)
    {
        $url = $this->config['is_production'] 
            ? "https://api.midtrans.com/v1/payment-links"
            : "https://api.sandbox.midtrans.com/v1/payment-links";

        $serverKey = $this->config['server_key'];
        $headers = [
            "Authorization: Basic " . base64_encode($serverKey . ":"),
            "Content-Type: application/json",
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    public function handleCallback(array $request)
    {
        return json_encode(['status' => 'handled', 'data' => $request]);
    }
}
