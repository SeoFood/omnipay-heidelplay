<?php

namespace Omnipay\Heidelpay\Tests\Message;

use Omnipay\Heidelpay\Message\AuthorizeRequest;
use Omnipay\Heidelpay\Message\ChargeRequest;
use Omnipay\Tests\TestCase;

class ChargeRequestTest extends TestCase
{
    /**
     * @var AuthorizeRequest
     */
    private $request;

    public function setUp()
    {
        $this->request = new ChargeRequest($this->getHttpClient(), $this->getHttpRequest());
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
        $this->setMockHttpResponse('ChargeSuccess.txt');
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertFalse($response->isPending());
    }

    public function testSendOptionalData()
    {
        $this->setMockHttpResponse('ChargeSuccess.txt');

        $this->request->setBasketId(1337);
        $this->request->setTransactionId(4567);
        $this->request->setReturnUrl('https://example.com');

        $data = $this->request->getData();

        $this->assertSame(1337, $data['resources.basketId']);
        $this->assertSame(4567, $data['orderId']);
        $this->assertSame('https://example.com', $data['returnUrl']);
    }

    public function testGetEndpoint()
    {
        $this->assertSame('https://api.heidelpay.com/v1/payments/charges', $this->request->getEndpoint());
    }
}