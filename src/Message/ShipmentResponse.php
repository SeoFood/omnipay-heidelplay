<?php

namespace Omnipay\Heidelpay\Message;

/**
 * ShipmentResponse
 */
class ShipmentResponse extends Response
{
    public function isSuccessful()
    {
        return !$this->data['isError'];
    }
}
