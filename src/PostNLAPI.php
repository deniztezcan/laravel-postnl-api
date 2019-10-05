<?php

namespace DenizTezcan\LaravelPostNLAPI;

use DenizTezcan\LaravelPostNLAPI\Services\Client;
use stdClass;

class PostNLAPI
{
    protected $customer;

    public function __constructor($customer = null)
    {
        if (null === $customer) {
            $this->customer = Customer::create([
                'CollectionLocation' => config('postnlapi.customer.location'),
                'CustomerCode'       => config('postnlapi.customer.code'),
                'CustomerNumber'     => config('postnlapi.customer.number'),
                'Address'            => Address::create([
                    'AddressType' => '02',
                    'City'        => config('postnlapi.customer.address.city'),
                    'CompanyName' => config('postnlapi.customer.address.companyName'),
                    'Countrycode' => config('postnlapi.customer.address.countryCode'),
                    'HouseNr'     => config('postnlapi.customer.address.streetNr'),
                    'Street'      => config('postnlapi.customer.address.street'),
                    'Zipcode'     => config('postnlapi.customer.address.postalcode'),
                ]),
                'Email'              => config('postnlapi.customer.email'),
            ]);
        } else {
            $this->customer = $customer;
        }
    }

    public function generateBarcode(
        $type = '3S',
        $serie = '000000000-999999999'
    ) {
        $client = new Client();
        $barcode = $client::get('shipment/v1_1/barcode?Type='.$type.'&Serie='.$serie, $this->customer);

        return $barcode['Barcode'];
    }

    public function generateLabel(
        $printerType = ''
    ) {
        $client = new Client();

        $generateData = new stdClass();
        $generateData->customer = $this->customer;
        $generateData->Message = LabellingMessage::create([
            'Printertype' => $printerType,
        ]);
        $generateData->Shipments = Shipments::create([
        ]);

        $label = $client::post('shipment/v2_1/label?confirm=true', $generateData, $this->customer);
    }
}
