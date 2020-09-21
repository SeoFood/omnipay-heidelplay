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
            'email' => $this->getCard()->getEmail(),
            'phone' => $this->getCard()->getPhone(),
        ];
        $data['billingAddress'] = $this->getAddressData('Billing');
        $data['shippingAddress'] = $this->getAddressData('Shipping');

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
            'firstname' => 'FirstName',
            'lastname' => 'LastName',
            'street' => 'Address1',
            'city' => 'City',
            'zip' => 'Postcode',
            'state' => 'State',
            'country' => 'Country'
        ];

        $data = [];

        foreach ($mapping as $heidelpayName => $omnipayName) {
            $data[$heidelpayName] = call_user_func([$card, 'get'.$type.$omnipayName]);
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
        return $this->response = new CreateCustomerResponse($this, $data);
    }
}
