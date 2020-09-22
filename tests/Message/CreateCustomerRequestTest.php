<?php

namespace Omnipay\Heidelpay\Tests\Message;

use Omnipay\Common\CreditCard;
use Omnipay\Heidelpay\Message\CreateCustomerRequest;
use Omnipay\Heidelpay\Message\CreateTypeRequest;
use Omnipay\Tests\TestCase;

class CreateCustomerRequestTest extends TestCase
{
    /**
     * @var CreateTypeRequest
     */
    private $request;

    public function setUp()
    {
        $this->request = new CreateCustomerRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(
            [
                'card' => new CreditCard([
                    'FirstName' => 'Karl'
                ]),
            ]
        );
    }

    public function testSend()
    {
        $this->setMockHttpResponse('CustomerSuccess.txt');

        $data = $this->request->getData();
        $this->assertSame('Karl', $data['firstname']);
        $this->assertSame('Karl', $data['billingAddress.name']);

        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertSame('s-cst-eb45f830ee46', $response->getTransactionReference());
    }

    public function testGetEndpoint()
    {
        $this->assertSame('https://api.heidelpay.com/v1/customers', $this->request->getEndpoint());
    }
}