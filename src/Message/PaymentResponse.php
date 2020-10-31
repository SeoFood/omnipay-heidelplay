<?php

namespace Omnipay\Heidelpay\Message;

/**
 * PaymentResponse
 */
class PaymentResponse extends Response
{
    public function isSuccessful()
    {
        return !$this->data['isError'];
    }

    public function isRedirect()
    {
        return isset($this->data['redirectUrl']);
    }

    public function getRedirectUrl()
    {
        return $this->data['redirectUrl'];
    }

    public function isPending()
    {
        return $this->data['isPending'];
    }

    public function getTransactionReference()
    {
        if (isset($this->data['id'])) {
            return $this->data['resources']['paymentId'];
        }
    }
}
