<?php


namespace Omnipay\Heidelpay\Tests;

use Omnipay\Common\CreditCard;
use Omnipay\Heidelpay\Gateway;
use Omnipay\Heidelpay\Message\CreateCustomerResponse;
use Omnipay\Heidelpay\Message\CreateTypeResponse;
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
        $this->setMockHttpResponse('CreateTypeSuccess.txt');

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
        $this->assertInstanceOf(CreateCustomerResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertSame('s-cst-eb45f830ee46', $response->getTransactionReference());
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
        $this->assertSame('s-aut-1', $response->getTransactionReference());
    }

    public function testCapture()
    {
        $this->setMockHttpResponse('AuthorizeSuccess.txt');

        $response = $this->gateway->capture(['amount' => '10.00', 'currency' => 'EUR', 'typeId' => '123'])->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertInstanceOf('Omnipay\Heidelpay\Message\Response', $response);
        $this->assertSame('s-aut-1', $response->getTransactionReference());
    }

    public function testCharge()
    {
        $this->setMockHttpResponse('AuthorizeSuccess.txt');

        $response = $this->gateway->purchase(['amount' => '10.00', 'currency' => 'EUR', 'typeId' => '123'])->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertInstanceOf('Omnipay\Heidelpay\Message\Response', $response);
        $this->assertSame('s-aut-1', $response->getTransactionReference());
    }

}
