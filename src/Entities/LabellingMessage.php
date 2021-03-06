<?php

namespace DenizTezcan\LaravelPostNLAPI\Entities;

class LabellingMessage extends AbstractEntity
{
    public $Printertype;

    public function __construct(
        $printerType = 'GraphicFile|PDF'
    ) {
        parent::__construct();
        $this->setPrintertype($printerType);
    }
}
