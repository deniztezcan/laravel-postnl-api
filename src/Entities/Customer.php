<?php

namespace DenizTezcan\LaravelPostNLAPI\Entities;

class Customer extends AbstractEntity
{
    protected $Address;
    protected $CollectionLocation;
    protected $CustomerCode;
    protected $CustomerNumber;
    protected $GlobalPackCustomerCode;
    protected $GlobalPackBarcodeType;
    protected $Email;

    public function __construct(
        $customerNr = null,
        $customerCode = null,
        $collectionLocation = null,
        $email = null,
        Address $address = null
    ) {
        parent::__construct();
        $this->setCustomerNumber($customerNr);
        $this->setCustomerCode($customerCode);
        $this->setCollectionLocation($collectionLocation);
        $this->setEmail($email);
        $this->setAddress($address);
    }
}
