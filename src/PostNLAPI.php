<?php

namespace DenizTezcan\LaravelPostNLAPI;

use DenizTezcan\LaravelPostNLAPI\Entities\Address;
use DenizTezcan\LaravelPostNLAPI\Entities\Customer;
use DenizTezcan\LaravelPostNLAPI\Entities\Group;
use DenizTezcan\LaravelPostNLAPI\Entities\LabellingMessage;
use DenizTezcan\LaravelPostNLAPI\Entities\Shipments;
use DenizTezcan\LaravelPostNLAPI\Services\Client;
use DenizTezcan\LaravelPostNLAPI\Services\Converter;

class PostNLAPI
{
    protected $customer;

    public function __construct($customer = null)
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

    public function setCustomer($customer)
    {
        $this->customer = $customer;
        return $this;
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
        $barcode,
        $printerType,
        $address,
        $contact,
        $deliveryAddress,
        $productCodeDelivery,
        $reference,
        $remark
    ) {
        $client = new Client();
        $data = Converter::Label(
            $this->customer,
            LabellingMessage::create([
                'Printertype' => $printerType,
            ]),
            Shipments::create([
                'Addresses'             => $address,
                'Barcode'               => $barcode,
                'Contacts'              => $contact,
                'DeliveryAddress'       => $deliveryAddress,
                'ProductCodeDelivery'   => $productCodeDelivery,
                'Reference'             => $reference,
                'Remark'                => $remark,
            ])
        );

        $label = $client::post('shipment/v2_2/label?confirm=true', $data, $this->customer);

        return $label['ResponseShipments'][0]['Labels'];
    }

    public function generateMultiColloLabel(
        $mainbarcode,
        $barcodes,
        $printerType,
        $address,
        $contact,
        $deliveryAddress,
        $productCodeDelivery,
        $reference,
        $remark
    ) {
        $client = new Client();
        $shipments = [];
        $sequence = 1;

        foreach ($barcodes as $barcode) {
            $shipments[] = Shipments::create([
                'Addresses'             => $address,
                'Barcode'               => $barcode,
                'Contacts'              => $contact,
                'DeliveryAddress'       => $deliveryAddress,
                'ProductCodeDelivery'   => $productCodeDelivery,
                'Reference'             => $reference,
                'Remark'                => $remark,
                'Groups'                => Group::create([
                    'GroupCount'    => count($barcodes),
                    'GroupSequence' => $sequence,
                    'GroupType'     => '03',
                    'MainBarcode'   => $mainbarcode,
                ]),
            ]);
            $sequence++;
        }

        $data = Converter::MultiLabel(
            $this->customer,
            LabellingMessage::create([
                'Printertype' => $printerType,
            ]),
            $shipments
        );

        $response = $client::post('shipment/v2_2/label?confirm=true', $data, $this->customer);
        $labels = [];

        foreach ($response['ResponseShipments'] as $label) {
            $labels[] = $label['Labels'];
        }

        return $labels;
    }

    public function nearestLocations(
        $countryCode = 'NL',
        $postalCode = '1111AA',
        $deliveryOptions = 'PG'
    ) {
        $client = new Client();
        $locations = $client::get('shipment/v2_1/locations/nearest?CountryCode='.$countryCode.'&PostalCode='.$postalCode.'&DeliveryOptions='.$deliveryOptions, $this->customer);

        return $locations['GetLocationsResult']['ResponseLocation'];
    }
}
