<?php
namespace Atriontechsd\SimpleTable\App;

interface ModalInterface
{
    public function modal(
        string $component,
        string $column
    );
}