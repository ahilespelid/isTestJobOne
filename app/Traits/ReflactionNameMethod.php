<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait ReflactionNameMethod
{
    public function getNameMethod()
    {
        $class = (new \ReflectionClass($this))->name ?? false;
        return ($class && empty($method = debug_backtrace()[1]['function'])) ? null : $class.'@'.$method;
    }
}
