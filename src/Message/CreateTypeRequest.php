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

        $parameters = parent::getParameters();
        unset($parameters['type']);

        return $parameters;
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

    public function setParameter($key, $value)
    {
        return parent::setParameter($key, $value);
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
