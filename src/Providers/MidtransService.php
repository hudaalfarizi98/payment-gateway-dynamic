<?php

namespace PaymentGatewayManager\Providers;

use PaymentGatewayManager\Contracts\PaymentGatewayInterface;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransService implements PaymentGatewayInterface
{
    public function __construct(array $config)
    {
        Config::$serverKey = $config['server_key'];
        Config::$isProduction = $config['is_production'];
    }

    public function createTransaction(array $data)
    {
        return Snap::getSnapToken($data);
    }

    public function handleCallback(array $request)
    {
        return json_encode(['status' => 'handled', 'data' => $request]);
    }
}
