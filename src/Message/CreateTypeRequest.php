<?php


namespace Omnipay\Heidelpay\Message;

class CreateTypeRequest extends AbstractRequest
{
    /**
     * @return array|mixed
     */
    public function getData()
    {
        $this->validate('type');

        return [];
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->getParameter('type');
    }

    /**
     * @param $value
     * @return CreateTypeRequest
     */
    public function setType($value)
    {
        return $this->setParameter('type', $value);
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return parent::getEndpoint() . 'types/' . $this->getType();
    }

    protected function createResponse($data)
    {
        return $this->response = new CreateTypeResponse($this, $data);
    }
}
