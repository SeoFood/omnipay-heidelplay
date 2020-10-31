<?php
namespace Omnipay\Heidelpay\Message;

/**
 * Charge Request
 *
 * @method Response send()
 */
class ShipmentRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('transactionId');

        $data = [];

        if ($this->getTransactionReference()) {
            $data['invoiceId'] = $this->getTransactionReference();
        }

        return $data;
    }

    public function getEndpoint()
    {
        return parent::getEndpoint() . 'payments/' . $this->getTransactionId() . '/shipments';
    }


    protected function createResponse($data)
    {
        return $this->response = new ShipmentResponse($this, $data);
    }
}
