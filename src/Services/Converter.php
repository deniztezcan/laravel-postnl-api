<?php

namespace DenizTezcan\LaravelPostNLAPI\Services;

use Carbon\Carbon;
use DenizTezcan\LaravelPostNLAPI\Entities\Customer;
use DenizTezcan\LaravelPostNLAPI\Entities\LabellingMessage;
use DenizTezcan\LaravelPostNLAPI\Entities\Shipments;

class Converter
{
    public static function Label(
        Customer $customer,
        LabellingMessage $message,
        Shipments $shipments
    ) {
        $data = new \stdClass();
        $data->Customer = new \stdClass();
        $data->Customer->Address = new \stdClass();
        $data->Customer->Address->AddressType = $customer->getAddress()->getAddressType();
        $data->Customer->Address->City = $customer->getAddress()->getCity();
        $data->Customer->Address->CompanyName = $customer->getAddress()->getCompanyName();
        $data->Customer->Address->Countrycode = $customer->getAddress()->getCountrycode();
        $data->Customer->Address->HouseNr = $customer->getAddress()->getHouseNr();
        $data->Customer->Address->HouseNrExt = $customer->getAddress()->getHouseNrExt();
        $data->Customer->Address->Street = $customer->getAddress()->getStreet();
        $data->Customer->Address->Zipcode = $customer->getAddress()->getZipcode();
        $data->Customer->CollectionLocation = $customer->getCollectionLocation();
        $data->Customer->CustomerCode = $customer->getCustomerCode();
        $data->Customer->CustomerNumber = $customer->getCustomerNumber();
        $data->Customer->Email = $customer->getEmail();

        $data->Message = new \stdClass();
        $data->Message->MessageID = 1;
        $data->Message->MessageTimeStamp = Carbon::now()->format('d-m-Y H:i:s');
        $data->Message->Printertype = $message->Printertype;

        $shipmentsAddresses = [];
        foreach ($shipments->getAddresses() as $shipmentAddress) {
            $address = new \stdClass();
            $address->AddressType = $shipmentAddress->getAddressType();
            $address->City = $shipmentAddress->getCity();
            $address->CompanyName = $shipmentAddress->getCompanyName();
            $address->Countrycode = $shipmentAddress->getCountrycode();
            $address->HouseNr = $shipmentAddress->getHouseNr();
            $address->HouseNrExt = $shipmentAddress->getHouseNrExt();
            $address->Street = $shipmentAddress->getStreet();
            $address->Zipcode = $shipmentAddress->getZipcode();

            $shipmentsAddresses[] = $address;
        }

        $shipmentsContacts = [];
        foreach ($shipments->getContacts() as $shipmentContact) {
            $contact = new \stdClass();
            $contact->ContactType = $shipmentContact->getContactType();
            $contact->Email = $shipmentContact->getEmail();
            $contact->SMSNr = $shipmentContact->getSMSNr();
            $contact->TelNr = $shipmentContact->getTelNr();
            $shipmentsContacts[] = $contact;
        }

        $data->Shipments = new \stdClass();
        $data->Shipments->Addresses = $shipmentsAddresses;
        $data->Shipments->Barcode = $shipments->getBarcode();
        $data->Shipments->Contacts = $shipmentsContacts;
        if($shipments->getDeliveryAddress() !== null){
            $data->Shipments->DeliveryAddress = $shipments->getDeliveryAddress();
        }
        $data->Shipments->ProductCodeDelivery = $shipments->getProductCodeDelivery();
        $data->Shipments->Reference = $shipments->getReference();
        $data->Shipments->Remark = $shipments->getRemark();

        return $data;
    }

    public static function MultiLabel(
        Customer $customer,
        LabellingMessage $message,
        array $shipments
    ) {
        $data = new \stdClass();
        $data->Customer = new \stdClass();
        $data->Customer->Address = new \stdClass();
        $data->Customer->Address->AddressType = $customer->getAddress()->getAddressType();
        $data->Customer->Address->City = $customer->getAddress()->getCity();
        $data->Customer->Address->CompanyName = $customer->getAddress()->getCompanyName();
        $data->Customer->Address->Countrycode = $customer->getAddress()->getCountrycode();
        $data->Customer->Address->HouseNr = $customer->getAddress()->getHouseNr();
        $data->Customer->Address->HouseNrExt = $customer->getAddress()->getHouseNrExt();
        $data->Customer->Address->Street = $customer->getAddress()->getStreet();
        $data->Customer->Address->Zipcode = $customer->getAddress()->getZipcode();
        $data->Customer->CollectionLocation = $customer->getCollectionLocation();
        $data->Customer->CustomerCode = $customer->getCustomerCode();
        $data->Customer->CustomerNumber = $customer->getCustomerNumber();
        $data->Customer->Email = $customer->getEmail();

        $data->Message = new \stdClass();
        $data->Message->MessageID = 1;
        $data->Message->MessageTimeStamp = Carbon::now()->format('d-m-Y H:i:s');
        $data->Message->Printertype = $message->Printertype;

        $shipmentsAddresses = [];
        $shipmentsContacts = [];
        $shipmentsArr = [];

        foreach ($shipments as $shipment) {
            if (count($shipmentsAddresses) == 0) {
                foreach ($shipment->getAddresses() as $shipmentAddress) {
                    $address = new \stdClass();
                    $address->AddressType = $shipmentAddress->getAddressType();
                    $address->City = $shipmentAddress->getCity();
                    $address->CompanyName = $shipmentAddress->getCompanyName();
                    $address->Countrycode = $shipmentAddress->getCountrycode();
                    $address->HouseNr = $shipmentAddress->getHouseNr();
                    $address->HouseNrExt = $shipmentAddress->getHouseNrExt();
                    $address->Street = $shipmentAddress->getStreet();
                    $address->Zipcode = $shipmentAddress->getZipcode();
                    $shipmentsAddresses[] = $address;
                }
                foreach ($shipment->getContacts() as $shipmentContact) {
                    $contact = new \stdClass();
                    $contact->ContactType = $shipmentContact->getContactType();
                    $contact->Email = $shipmentContact->getEmail();
                    $contact->SMSNr = $shipmentContact->getSMSNr();
                    $contact->TelNr = $shipmentContact->getTelNr();
                    $shipmentsContacts[] = $contact;
                }
            }

            $xshipment = new \stdClass();
            $xshipment->Addresses = $shipmentsAddresses;
            $xshipment->Barcode = $shipment->getBarcode();
            $xshipment->Contacts = $shipmentsContacts;
            if($shipment->getDeliveryAddress() !== null){
                $xshipment->DeliveryAddress = $shipment->getDeliveryAddress();
            }
            $xshipment->ProductCodeDelivery = $shipment->getProductCodeDelivery();
            $xshipment->Reference = $shipment->getReference();
            $xshipment->Remark = $shipment->getRemark();
            $xshipment->Groups = new \stdClass();
            $xshipment->Groups->Group = new \stdClass();
            $xshipment->Groups->Group->GroupCount = $shipment->getGroups()->getGroupCount();
            $xshipment->Groups->Group->GroupSequence = $shipment->getGroups()->getGroupSequence();
            $xshipment->Groups->Group->GroupType = $shipment->getGroups()->getGroupType();
            $xshipment->Groups->Group->MainBarcode = $shipment->getGroups()->getMainBarcode();
            $shipmentsArr[] = $xshipment;
        }

        $data->Shipments = $shipmentsArr;

        return $data;
    }
}
