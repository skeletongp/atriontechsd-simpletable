<?php

namespace Atriontechsd\SimpleTable;
interface TableInterfaz {

    public function columns() : array;

    public function setTable() : string;

    public function joins() : array;

    public function edit($key_name, $key_value, $table);

    

    
}