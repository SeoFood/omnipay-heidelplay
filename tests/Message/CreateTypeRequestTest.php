<?php

namespace Omnipay\Heidelpay\Tests\Message;

use Omnipay\Heidelpay\Message\CreateTypeRequest;
use Omnipay\Tests\TestCase;

class CreateTypeRequestTest extends TestCase
{
    /**
     * @var CreateTypeRequest
     */
    private $request;

    public function setUp()
    {
        $this->request = new CreateTypeRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(
            [
                'type' => 'invoice-guaranteed'
            ]
        );
    }

    public function testSend()
    {
        $this->setMockHttpResponse('CreateTypeSuccess.txt');
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertSame('invoice-guaranteed', $response->getType());
    }

    public function testGetEndpoint()
    {
        $this->assertSame('https://api.heidelpay.com/v1/types/invoice-guaranteed', $this->request->getEndpoint());
    }
}