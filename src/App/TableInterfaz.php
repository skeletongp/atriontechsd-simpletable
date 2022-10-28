<?php

namespace Atriontechsd\SimpleTable\App;

interface TableInterfaz {

    public function columns() : array;

    public function setTable() : string;

    public function joins() : array;

    public function edit($key_name, $key_value, $table);

    

    
}