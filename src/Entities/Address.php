<?php

namespace DenizTezcan\LaravelPostNLAPI\Entities;

class Address extends AbstractEntity
{
    protected $AddressType;
    protected $Area;
    protected $Buildingname;
    protected $City;
    protected $CompanyName;
    protected $Countrycode;
    protected $Department;
    protected $Doorcode;
    protected $FirstName;
    protected $Floor;
    protected $HouseNr;
    protected $HouseNrExt;
    protected $StreetHouseNrExt;
    protected $Name;
    protected $Region;
    protected $Remark;
    protected $Street;
    protected $Zipcode;
    protected $other;

    public function __construct(
        $addressType = null,
        $firstName = null,
        $name = null,
        $companyName = null,
        $street = null,
        $houseNr = null,
        $houseNrExt = null,
        $zipcode = null,
        $city = null,
        $countryCode = null,
        $area = null,
        $buildingName = null,
        $department = null,
        $doorcode = null,
        $floor = null,
        $region = null,
        $remark = null,
        $streetHouseNrExt = null
    ) {
        parent::__construct();
        $this->setAddressType($addressType);
        $this->setFirstName($firstName);
        $this->setName($name);
        $this->setCompanyName($companyName);
        $this->setStreet($street);
        $this->setHouseNr($houseNr);
        $this->setHouseNrExt($houseNrExt);
        $this->setZipcode($zipcode);
        $this->setCity($city);
        $this->setCountrycode($countryCode);
        $this->setArea($area);
        $this->setBuildingname($buildingName);
        $this->setDepartment($department);
        $this->setDoorcode($doorcode);
        $this->setFloor($floor);
        $this->setRegion($region);
        $this->setRemark($remark);
        $this->setStreetHouseNrExt($streetHouseNrExt);
    }
}
