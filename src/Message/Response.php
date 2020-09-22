<?php

namespace Omnipay\Heidelpay\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * Response
 */
class Response extends AbstractResponse
{
    public function isSuccessful()
    {
        return isset($this->data['id']);
    }

    public function getTransactionReference()
    {
        if (isset($this->data['id'])) {
            return $this->data['id'];
        }
    }
}
