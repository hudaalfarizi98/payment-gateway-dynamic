<?php

namespace PaymentGatewayManager;

use PaymentGatewayManager\Contracts\PaymentGatewayInterface;
use PaymentGatewayManager\Providers\MidtransService;
use PaymentGatewayManager\Providers\XenditService;

class PaymentGatewayManager
{
    protected $provider;

    public function __construct(string $provider, array $config)
    {
        switch ($provider) {
            case 'midtrans':
                $this->provider = new MidtransService($config);
                break;
            case 'xendit':
                $this->provider = new XenditService($config);
                break;
            default:
                throw new \Exception("Provider not supported");
        }
    }

    public function createTransaction(array $data)
    {
        return $this->provider->createTransaction($data);
    }

    public function createPaymentLink(array $data)
    {
        return $this->provider->createPaymentLink($data);
    }

    public function handleCallback(array $request)
    {
        return $this->provider->handleCallback($request);
    }
}
