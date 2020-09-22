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
        $this->validate('transactionReference');

        return [];
    }

    public function getEndpoint()
    {
        return parent::getEndpoint() . $this->getTransactionReference() . '/shipments';
    }
}
