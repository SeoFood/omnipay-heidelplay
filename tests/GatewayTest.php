<?php


namespace Omnipay\Heidelpay\Tests;

use Omnipay\Common\CreditCard;
use Omnipay\Common\ItemBag;
use Omnipay\Heidelpay\Gateway;
use Omnipay\Heidelpay\Message\CreateTypeResponse;
use Omnipay\Heidelpay\Message\Response;
use Omnipay\Tests\GatewayTestCase;

/**
 * Class GatewayTest
 * @package Omnipay\Heidelpay
 */
class GatewayTest extends GatewayTestCase
{
    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
//        $this->gateway = new Gateway();
    }

    /**
     *
     */
    public function testCreateType()
    {
        $this->setMockHttpResponse('TypeSuccess.txt');

        $response = $this->gateway->createType(['type' => 'invoice-guaranteed'])->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertInstanceOf(CreateTypeResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertSame('invoice-guaranteed', $response->getType());
        $this->assertSame('s-ivg-k9vmwho6rgds', $response->getTransactionReference());
    }

    /**
     *
     */
    public function testCreateCustomer()
    {
        $this->setMockHttpResponse('CustomerSuccess.txt');

        $card = new CreditCard();
        $card->setFirstName('Karl');

        $response = $this->gateway->createCustomer(compact('card'))->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertInstanceOf(Response::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertSame('s-cst-eb45f830ee46', $response->getTransactionReference());
    }

    /**
     *
     */
    public function testCreateBasket()
    {
        $this->setMockHttpResponse('BasketSuccess.txt');


        $response = $this->gateway->createBasket([
            'amount' => 200,
            'transactionId' => 1337,
            'currency' => 'EUR',
            'items' => new ItemBag()
        ])->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertInstanceOf(Response::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertSame('s-bsk-1', $response->getTransactionReference());
    }

    /**
     *
     */
    public function testAuthorize()
    {
        $this->setMockHttpResponse('AuthorizeSuccess.txt');

        $response = $this->gateway->authorize(['amount' => '10.00', 'currency' => 'EUR', 'typeId' => '123'])->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertInstanceOf('Omnipay\Heidelpay\Message\Response', $response);
        $this->assertSame('s-pay-1', $response->getTransactionReference());
    }

    public function testCapture()
    {
        $this->setMockHttpResponse('CaptureSuccess.txt');

        $response = $this->gateway->capture([
            'transactionReference' => 1337,
            'transactionId' => 's-pay-762',
        ])->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertInstanceOf('Omnipay\Heidelpay\Message\Response', $response);
        $this->assertSame('s-shp-1', $response->getTransactionReference());
    }

    public function testCharge()
    {
        $this->setMockHttpResponse('AuthorizeSuccess.txt');

        $response = $this->gateway->purchase(['amount' => '10.00', 'currency' => 'EUR', 'typeId' => '123'])->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertInstanceOf('Omnipay\Heidelpay\Message\Response', $response);
        $this->assertSame('s-pay-1', $response->getTransactionReference());
    }

}
