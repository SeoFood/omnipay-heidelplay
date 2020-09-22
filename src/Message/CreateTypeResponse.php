<?php

namespace Omnipay\Heidelpay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

/**
 * Response
 */
class CreateTypeResponse extends Response
{
    public function isSuccessful()
    {
        return isset($this->data['method']);
    }

    public function getType()
    {
        if (isset($this->data['method'])) {
            return $this->data['method'];
        }
    }
}
