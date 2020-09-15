<?php
namespace Omnipay\Heidelpay\Message;

/**
 * Authorize Request
 *
 * @method Response send()
 */
class AuthorizeRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('amount', 'currency', 'typeId');

        $data = [];
        $data['amount'] = $this->getAmount();
        $data['currency'] = $this->getCurrency();
        $data['resources'] = [
            'typeId' => $this->getTypeId()
        ];

        return $data;
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
        return parent::getEndpoint() . 'payments/authorize';
    }
}
