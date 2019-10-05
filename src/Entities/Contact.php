<?php

namespace DenizTezcan\LaravelPostNLAPI\Entities;

class Contact extends AbstractEntity
{
	protected $ContactType;
    protected $Email;
    protected $SMSNr;
    protected $TelNr;
    
    public function __construct($contactType = null, $email = null, $smsNr = null, $telNr = null)
    {
        parent::__construct();
        $this->setContactType($contactType);
        $this->setEmail($email);
        $this->setSMSNr($smsNr);
        $this->setTelNr($telNr);
    }
}