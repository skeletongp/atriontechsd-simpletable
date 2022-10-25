<?php

namespace Atriontechsd\SimpleTable;
interface TableInterfaz {

    public function columns() : array;

    public function setTable() : string;

    public function joins() : array;

    
}