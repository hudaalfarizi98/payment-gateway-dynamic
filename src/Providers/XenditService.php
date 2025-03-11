<?php

namespace PaymentGatewayManager\Providers;

use PaymentGatewayManager\Contracts\PaymentGatewayInterface;
use Xendit\Xendit;

class XenditService implements PaymentGatewayInterface
{
    public function __construct(array $config)
    {
        Xendit::setApiKey($config['api_key']);
    }

    public function createTransaction(array $data)
    {
        return json_encode(['message' => 'Xendit transaction created', 'data' => $data]);
    }

    public function handleCallback(array $request)
    {
        return json_encode(['status' => 'handled', 'data' => $request]);
    }
}
