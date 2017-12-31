<?php

namespace App\Inspections;

use Exception;

class KeyHeldDown
{

    public function detect($text)
    {
        throw_if(preg_match('/(.)\\1{4,}/',$text), new Exception('Your Reply Contains Spam'));
    }
}