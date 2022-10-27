<?php

namespace Atriontechsd\SimpleTable\Styles;

trait TableStyles
{
    public $titleClass;
    public  $cellClass;
    public  $columnClass;
    public $rowClass;
    public $expanded=false;


    public function titleClass($titleClass)
    {
        $this->titleClass = $titleClass;
        return $this;
    }
    public function cellClass($cellClass)
    {
        $this->cellClass = $cellClass;
        return $this;
    }
    public function columnClass($columnClass)
    {
        $this->columnClass = $columnClass;
        return $this;
    }
    public function rowClass($rowClass)
    {
        $this->rowClass = $rowClass;
        return $this;
    }
    public function setStyles(
        $titleClass = "",
        $columnClass = "",
        $rowClass = ""
    ) {
        $this->titleClass = $titleClass;
        $this->columnClass = $columnClass;
        $this->rowClass = $rowClass;
    }
}
