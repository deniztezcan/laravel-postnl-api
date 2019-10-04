<?php

namespace DenizTezcan\LaravelPostNLAPI\Entities;

class Message extends AbstractEntity
{
    protected $MessageID;
    protected $MessageTimeStamp;

    public function __construct($mid = null, $timestamp = null)
    {
        parent::__construct();
        $this->setMessageID($mid ?: substr(str_replace('-', '', $this->getid()), 0, 12));
        $this->setMessageTimeStamp($timestamp ?: (new DateTime())->format('d-m-Y H:i:s'));
    }
}
