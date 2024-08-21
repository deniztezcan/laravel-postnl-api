<?php

namespace DenizTezcan\PostNL\Entities;

class Parcel extends Entity
{
    public array $data = [];

    public array $receiver = ['type' => 'consumer'];

    public array $receiverContact = [];

    public array $receiverAddress = [];

    public array $sender = ['customerNumber' => config('postnl.customer.number'), 'customerCode' => config('postnl.customer.code')];

    public array $returnOptions = [];

    public array $returnAddress = [];

    public int $itemCount = 1;

    public array $items = [];

    public string $customerReference = '';

    public string $type = 'parcel';

    public string $outputType = 'pdf';

    public string $orientation = 'landscape';

    public array $services = [];

    public array $deliveryLocation = [];

    public array $deliveryLocationAddress = [];

    public string $handOverDate = '';

    public function setHandOverDate(): Parcel
    {
        $this->handOverDate = date('Y-m-d');

        return $this;
    }

    public function setReceiverContact(
        string $firstName,
        string $lastName,
        string $telephoneNumber,
        string $email,
        ?string $language = null,
        ?string $companyName = null,
    ): Parcel {
        $this->receiverContact = [
            'firstName' => $firstName,
            'lastName' => $lastName,
            'telephoneNumber' => $telephoneNumber,
            'email' => $email,
        ];

        if ($language !== null) {
            $this->receiverContact['language'] = $language;
        }

        if ($companyName !== null) {
            $this->receiverContact['companyName'] = $companyName;
        }

        return $this;
    }

    public function setReceiverAddress(
        string $city,
        string $countryIso,
        string $houseNumber,
        string $postalCode,
        string $street,
        ?string $houseNumberAddition = null,
    ): Parcel {
        $this->receiverAddress = [
            'city' => $city,
            'countryIso' => $countryIso,
            'houseNumber' => $houseNumber,
            'postalCode' => $postalCode,
            'street' => $street,
        ];

        if ($houseNumberAddition !== null) {
            $this->receiverAddress['houseNumberAddition'] = $houseNumberAddition;
        }

        return $this;
    }

    public function setreturnAddress(
        string $city,
        string $countryIso,
        string $houseNumber,
        string $postalCode,
        string $street,
        ?string $houseNumberAddition = null,
    ): Parcel {
        $this->returnAddress = [
            'city' => $city,
            'countryIso' => $countryIso,
            'houseNumber' => $houseNumber,
            'postalCode' => $postalCode,
            'street' => $street,
        ];

        if ($houseNumberAddition !== null) {
            $this->returnAddress['houseNumberAddition'] = $houseNumberAddition;
        }

        return $this;
    }

    public function setItemCount(int $itemCount = 1): Parcel
    {
        $this->itemCount = $itemCount;

        return $this;
    }

    public function setCustomerReference(string $customerReference = ''): Parcel
    {
        $this->customerReference = $customerReference;

        return $this;
    }

    public function setType(string $type = ''): Parcel
    {
        $this->type = $type;

        return $this;
    }

    public function setOutputType(string $outputType = ''): Parcel
    {
        $this->outputType = $outputType;

        return $this;
    }

    public function setOrientation(string $orientation = ''): Parcel
    {
        $this->orientation = $orientation;

        return $this;
    }

    public function setServices(array $services = []): Parcel
    {
        $this->services = $services;

        return $this;
    }

    public function setDeliveryLocationAddress(
        string $city,
        string $countryIso,
        string $houseNumber,
        string $postalCode,
        string $street,
        ?string $houseNumberAddition = null,
    ): Parcel {
        $this->deliveryLocationAddress = [
            'city' => $city,
            'countryIso' => $countryIso,
            'houseNumber' => $houseNumber,
            'postalCode' => $postalCode,
            'street' => $street,
        ];

        if ($houseNumberAddition !== null) {
            $this->deliveryLocationAddress['houseNumberAddition'] = $houseNumberAddition;
        }

        return $this;
    }

    private function prepareItems()
    {
        for ($i = 0; $i < $this->itemCount; $i++) {
            $this->items[] = [
                // 'label' => [
                'barcode' => '',
                // 'outputType' => $this->outputType,
                // 'orientation' => $this->orientation,
                // ],
            ];
        }
    }

    private function prepareData()
    {
        $this->receiver['contact'] = $this->receiverContact;
        $this->receiver['address'] = $this->receiverAddress;
        $this->sender['address'] = $this->returnAddress;
        $this->prepareItems();

        $this->data = [
            'receiver' => $this->receiver,
            'sender' => $this->sender,
            'itemCount' => $this->itemCount,
            'items' => $this->items,
            'customerReferences' => [
                'shipmentReference' => $this->customerReference,
            ],
            'type' => $this->type,
            'labelSettings' => [
                'outputType' => $this->outputType,
                // 'orientation' => $this->orientation, // TODO Q'n'D FIX TO CHANGE LABEL
            ],
            // remove returnoptions
            'returnOptions' => [
                'returnAddress' => $this->returnAddress,
            ],
        ];

        if (count($this->services) > 0) {
            $this->data['services'] = $this->services;
        }

        if (isset($this->deliveryLocationAddress['city']) && $this->deliveryLocationAddress['city'] != '') {
            $this->deliveryLocation['address'] = $this->deliveryLocationAddress;
            $this->data['deliveryLocation'] = $this->deliveryLocation;
        }

        if ($this->handOverDate != '') {
            $this->data['handOverDate'] = $this->handOverDate;
        }
    }

    public function send()
    {
        $this->prepareData();

        $response = $this->client->request('POST', '/beta', $this->data);

        return json_decode($response->getBody()->getContents(), true);
    }
}

