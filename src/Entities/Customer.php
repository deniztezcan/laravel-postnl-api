<?php

namespace DenizTezcan\LaravelPostNLAPI\Entities;

class Customer extends AbstractEntity
{
    protected $Address;
    protected $CollectionLocation;
    protected $ContactPerson;
    protected $CustomerCode;
    protected $CustomerNumber;
    protected $GlobalPackCustomerCode;
    protected $GlobalPackBarcodeType;
    protected $Email;
    protected $Name;

    public function __construct(
        $customerNr = null,
        $customerCode = null,
        $collectionLocation = null,
        $contactPerson = null,
        $email = null,
        $name = null,
        Address $address = null
    ) {
        parent::__construct();
        $this->setCustomerNumber($customerNr);
        $this->setCustomerCode($customerCode);
        $this->setCollectionLocation($collectionLocation);
        $this->setContactPerson($contactPerson);
        $this->setEmail($email);
        $this->setName($name);
        $this->setAddress($address);
    }
}
