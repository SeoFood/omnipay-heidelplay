<?php


namespace Omnipay\Heidelpay\Tests;

use Omnipay\Heidelpay\Gateway;
use Omnipay\Heidelpay\Message\CreateTypeRequest;
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
    public function testAuthorize()
    {
        $this->setMockHttpResponse('AuthorizeSuccess.txt');

        $response = $this->gateway->authorize(['amount' => '10.00', 'currency' => 'EUR', 'typeId' => '123'])->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertInstanceOf('Omnipay\Heidelpay\Message\Response', $response);
        $this->assertSame('s-aut-1', $response->getTransactionReference());
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
}
