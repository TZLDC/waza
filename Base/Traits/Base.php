<?php

namespace Base\Traits;

trait Base
{
    public function dump($a)
    {
        echo '<pre>';
        print_r($a);
        echo '</pre>';
    }
}
