<?php

namespace Omnipay\Heidelpay\Tests\Message;

use Omnipay\Common\CreditCard;
use Omnipay\Common\ItemBag;
use Omnipay\Heidelpay\Message\CreateBasketRequest;
use Omnipay\Heidelpay\Message\CreateCustomerRequest;
use Omnipay\Heidelpay\Message\CreateTypeRequest;
use Omnipay\Tests\TestCase;

class CreateBasketRequestTest extends TestCase
{
    /**
     * @var CreateTypeRequest
     */
    private $request;

    public function setUp()
    {
        $this->request = new CreateBasketRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(
            [
                'amount' => 200,
                'transactionId' => 1337,
                'currency' => 'EUR',
                'items' => new ItemBag([
                    [
                        'quantity' => 2,
                        'price' => 10,
                        'name' => 'Test 123'
                    ]
                ])
            ]
        );
    }

    public function testSend()
    {
        $this->setMockHttpResponse('BasketSuccess.txt');

        $data = $this->request->getData();

        $this->assertSame(200, $data['amountTotalGross']);
        $this->assertInternalType('array', $data['basketItems']);
        $this->assertSame(2, $data['basketItems'][0]['quantity']);
        $this->assertSame(10, $data['basketItems'][0]['amountPerUnit']);
        $this->assertSame(20, $data['basketItems'][0]['amountGross']);

        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertSame('s-bsk-1', $response->getTransactionReference());
    }

    public function testGetEndpoint()
    {
        $this->assertSame('https://api.heidelpay.com/v1/baskets', $this->request->getEndpoint());
    }
}