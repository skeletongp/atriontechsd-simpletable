<?php

namespace Atriontechsd\SimpleTable\App;

class Modal extends CommonColumn
{
    public function modal(
        string $component,
        string $column
    ) {
        $this->type = 'modal';
        $this->alias = $column;
        $this->isColumn = false;
        $makeModal = new MakeModal();
        $this->component = 
        $makeModal->createModal($component);
        return $this;
    }
}