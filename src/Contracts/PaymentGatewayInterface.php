<?php

namespace PaymentGatewayManager\Contracts;

interface PaymentGatewayInterface
{
    public function createTransaction(array $data);

    public function createPaymentLink(array $data);

    public function handleCallback(array $request);
}
