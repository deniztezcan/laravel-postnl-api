<?php

namespace DenizTezcan\LaravelPostNLAPI\Entities;

class LabellingMessage extends Message
{
	protected $Printertype;

	public function __construct(
        $printerType = 'GraphicFile|PDF',
        $mid = null,
        $timestamp = null
    ) {
        parent::__construct($mid, $timestamp);
        $this->setPrintertype($printerType);
    }
}