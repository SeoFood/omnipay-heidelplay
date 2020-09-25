<?php

namespace Omnipay\Heidelpay\Message;

use Omnipay\Common\Message\AbstractRequest as BaseAbstractRequest;

/**
 * Abstract Request
 *
 */
abstract class AbstractRequest extends BaseAbstractRequest
{
    protected $sdkVersion = '3.0.0';

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
        $body = $data ? http_build_query($data, '', '&') : null;
        $response = $this->httpClient->request(
            $this->getHttpMethod(),
            $this->getEndpoint(),
            [
                'SDK-TYPE' => 'Omnipay-SDK',
                'SDK-VERSION' => $this->sdkVersion,
                'Authorization' => 'Basic '.base64_encode($this->getApiKey().':'),
                'Content-Type' => 'application/x-www-form-urlencoded'
            ],
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
