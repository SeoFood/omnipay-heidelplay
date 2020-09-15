<?php

namespace Omnipay\Heidelpay\Tests\Message;

use Omnipay\Heidelpay\Message\AuthorizeRequest;
use Omnipay\Tests\TestCase;

class AuthorizeRequestTest extends TestCase
{
    /**
     * @var AuthorizeRequest
     */
    private $request;

    public function setUp()
    {
        $this->request = new AuthorizeRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(
            [
                'amount' => '12.00',
                'currency' => 'EUR',
                'typeId' => 's-crd-fm7tifzkqewy'
            ]
        );
    }

    public function testGetData()
    {
        $data = $this->request->getData();

        $this->assertSame('12.00', $data['amount']);
        $this->assertSame('EUR', $data['currency']);
    }

    public function testSend()
    {
        $this->setMockHttpResponse('AuthorizeSuccess.txt');
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
    }

    public function testGetEndpoint()
    {
        $this->assertSame('https://api.heidelpay.com/v1/payments/authorize', $this->request->getEndpoint());
    }
}