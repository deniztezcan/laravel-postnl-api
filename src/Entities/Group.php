<?php

namespace DenizTezcan\LaravelPostNLAPI\Entities;

class Group extends AbstractEntity
{
	protected $GroupCount;
    protected $GroupSequence;
    protected $GroupType;
    protected $MainBarcode;
 
    public function __construct($groupCount = null, $groupSequence = null, $groupType = null, $mainBarcode = null)
    {
        parent::__construct();
        $this->setGroupCount($groupCount);
        $this->setGroupSequence($groupSequence);
        $this->setGroupType($groupType);
        $this->setMainBarcode($mainBarcode);
    }
}