<?php
namespace Omnipay\Heidelpay\Message;

/**
 * Payment Request
 *
 * @method Response send()
 */
class PaymentRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('amount', 'currency', 'typeId');

        $data = [];
        $data['amount'] = $this->getAmount();
        $data['currency'] = $this->getCurrency();

        if ($this->getReturnUrl()) {
            $data['returnUrl'] = $this->getReturnUrl();
        }

        if ($this->getTransactionId()) {
            $data['orderId'] = $this->getTransactionId();
        }

        $data['resources'] = [
            'typeId' => $this->getTypeId()
        ];

        if ($this->getCustomerId()) {
            $data['resources']['customerId'] = $this->getCustomerId();
        }

        if ($this->getBasketId()) {
            $data['resources']['basketId'] = $this->getBasketId();
        }

        if ($this->getMetaDataId()) {
            $data['resources']['metadataid'] = $this->getMetaDataId();
        }

        return $data;
    }

    public function getMetaDataId()
    {
        return $this->getParameter('metadataid');
    }

    public function setMetaDataId($value)
    {
        return $this->setParameter('metadataid', $value);
    }

    public function getBasketId()
    {
        return $this->getParameter('basketId');
    }

    public function setBasketId($value)
    {
        return $this->setParameter('basketId', $value);
    }

    public function getCustomerId()
    {
        return $this->getParameter('customerId');
    }

    public function setCustomerId($value)
    {
        return $this->setParameter('customerId', $value);
    }

    public function getTypeId()
    {
        return $this->getParameter('typeId');
    }

    public function setTypeId($value)
    {
        return $this->setParameter('typeId', $value);
    }

    public function getEndpoint()
    {
        return parent::getEndpoint() . 'payments/';
    }
}
