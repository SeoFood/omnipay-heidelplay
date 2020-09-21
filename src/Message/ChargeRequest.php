<?php
namespace Omnipay\Heidelpay\Message;

/**
 * Charge Request
 *
 * @method Response send()
 */
class ChargeRequest extends PaymentRequest
{
    public function getEndpoint()
    {
        return parent::getEndpoint() . 'charges';
    }
}
