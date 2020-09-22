<?php


namespace Omnipay\Heidelpay\Message;

use Omnipay\Common\Item;

class CreateBasketRequest extends AbstractRequest
{
    /**
     * @return array
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('transactionId', 'currency', 'items', 'amount');

        $data = [
            'amountTotalGross' => $this->getAmountInteger() / 100,
            'currencyCode' => $this->getCurrency(),
            'orderId' => $this->getTransactionId(),
            'note' => $this->getDescription(),
            'basketItems' => $this->getItemsData()
        ];

        if ($this->getTaxAmount()) {
            $data['amountTotalVat'] = $this->getTaxAmount();
        }

        if ($this->getDiscount()) {
            $data['amountTotalDiscount'] = $this->getDiscount();
        }

        return $data;
    }

    /**
     * @return array
     */
    public function getItemsData()
    {
        $data = [];

        /** @var Item $item */
        foreach ($this->getItems() as $item) {
            $data[] = [
                'basketItemReferenceId' => uniqid(),
                'quantity' => $item->getQuantity(),
                'amountPerUnit' => $item->getPrice(),
                'amountGross' => $item->getPrice() * $item->getQuantity(),
                'title' => $item->getName(),
                'subTitle' => $item->getDescription()
            ];
        }

        return $data;
    }


    /**
     * @return string
     */
    public function getTaxAmount()
    {
        return $this->getParameter('tax_amount');
    }

    /**
     * @param $value
     * @return CreateBasketRequest
     */
    public function setTaxAmount($value)
    {
        return $this->setParameter('tax_amount', $value);
    }

    /**
     * @return string
     */
    public function getDiscount()
    {
        return $this->getParameter('discount');
    }

    /**
     * @param $value
     * @return CreateBasketRequest
     */
    public function setDiscount($value)
    {
        return $this->setParameter('discount', $value);
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return parent::getEndpoint().'baskets';
    }
}
