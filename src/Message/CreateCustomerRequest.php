<?php


namespace Omnipay\Heidelpay\Message;

class CreateCustomerRequest extends AbstractRequest
{
    /**
     * @return array|mixed
     */
    public function getData()
    {
        $this->validate('card');

        $data = [
            'firstname' => $this->getCard()->getFirstName(),
            'lastname' => $this->getCard()->getLastName(),
            'birthDate' => $this->getCard()->getBirthday(),
            'email' => $this->getCard()->getEmail()
        ];

        if ($this->getCard()->getPhone()) {
            $data['phone'] = $this->getCard()->getPhone();
        }

        if ($this->getCard()->getBillingName()) {
            $data = array_merge($data, $this->getAddressData('Billing'));
        }

        if ($this->getCard()->getShippingName()) {
            $data = array_merge($data, $this->getAddressData('Shipping'));
        }

        return $data;
    }

    /**
     * Get either the billing or the shipping address from
     * the card object, mapped to Heidelpay field names.
     *
     * @param  string  $type  'Billing' or 'Shipping'
     * @return array
     */
    protected function getAddressData($type = 'Billing')
    {
        $card = $this->getCard();

        $mapping = [
            'name' => 'Name',
            'street' => 'Address1',
            'city' => 'City',
            'zip' => 'Postcode',
            'state' => 'State',
            'country' => 'Country'
        ];

        $data = [];

        foreach ($mapping as $heidelpayName => $omnipayName) {
            $value = call_user_func([$card, 'get'.$type.$omnipayName]);
            if ($value !== null) {
                $data[strtolower($type) . 'Address.' . $heidelpayName] = $value;
            }
        }
        return $data;
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return parent::getEndpoint().'customers';
    }

    protected function createResponse($data)
    {
        return $this->response = new Response($this, $data);
    }
}
