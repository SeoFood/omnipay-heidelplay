<?php

namespace Omnipay\Heidelpay\Message;

use Omnipay\Common\Message\AbstractRequest as BaseAbstractRequest;

/**
 * Abstract Request
 *
 */
abstract class AbstractRequest extends BaseAbstractRequest
{
    protected $liveEndpoint = 'https://api.heidelpay.com/v1/';


    public function getApiKey()
    {
        return $this->getParameter('key');
    }

    public function setApiKey($value)
    {
        return $this->setParameter('key', $value);
    }

    protected function getHttpMethod()
    {
        return 'POST';
    }

    public function sendData($data)
    {
        $body = $data ? http_build_query($data) : null;

        $response = $this->httpClient->request(
            $this->getHttpMethod(),
            $this->getEndpoint(),
            array('Authorization' => 'Basic '.base64_encode($this->getApiKey().':')),
            $body
        );
        $data = json_decode($response->getBody(), true);

        return $this->createResponse($data);
    }

    /**
     * @return string
     */
    protected function getEndpoint()
    {
        return $this->liveEndpoint;
    }

    protected function createResponse($data)
    {
        return $this->response = new Response($this, $data);
    }
}
