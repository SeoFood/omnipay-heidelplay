<?php

namespace Omnipay\Heidelpay;

use Omnipay\Common\AbstractGateway;
use Omnipay\Heidelpay\Message\AuthorizeRequest;
use Omnipay\Heidelpay\Message\ChargeRequest;
use Omnipay\Heidelpay\Message\CreateCustomerRequest;
use Omnipay\Heidelpay\Message\CreateTypeRequest;

/**
 * Heidelpay Charge Gateway.
 *
 * @see \Omnipay\Heidelpay\AbstractGateway
 * @see \Omnipay\Heidelpay\Message\AbstractRequest
 *
 * @link https://docs.heidelpay.com/reference
 */
class Gateway extends AbstractGateway
{

    public function getName()
    {
        return 'Heidelpay';
    }

    /**
     * Get the gateway parameters.
     *
     * @return array
     */
    public function getDefaultParameters()
    {
        return array(
            'apiKey' => '',
            'testMode' => false
        );
    }

    /**
     * Get the gateway API Key.
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    /**
     * Set the gateway API Key.
     *
     * @param string $value
     *
     * @return Gateway provides a fluent interface.
     */
    public function setApiKey($value)
    {
        return $this->setParameter('apiKey', $value);
    }

    /**
     * Create a type request
     *
     * @param array $parameters
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function createType(array $parameters = array())
    {
        return $this->createRequest(CreateTypeRequest::class, $parameters);
    }

    /**
     * Create a customer request
     *
     * @param array $parameters
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function createCustomer(array $parameters = array())
    {
        return $this->createRequest(CreateCustomerRequest::class, $parameters);
    }

    /**
     * Authorize and handling of return from 3D Secure or PayPal redirection.
     * @param  array  $parameters
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function authorize(array $parameters = [])
    {
        return $this->createRequest(AuthorizeRequest::class, $parameters);
    }

    public function capture(array $parameters = array())
    {
        return $this->createRequest(ChargeRequest::class, $parameters);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest(ChargeRequest::class, $parameters);
    }
}
