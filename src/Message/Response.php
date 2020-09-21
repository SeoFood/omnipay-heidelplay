<?php

namespace Omnipay\Heidelpay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

/**
 * Response
 */
class Response extends AbstractResponse
{
    public function __construct(RequestInterface $request, $data)
    {
        $this->request = $request;
        $this->data = $data;
    }

    public function isSuccessful()
    {
        return $this->data['isSuccess'];
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
            return $this->data['id'];
        }
    }
}
