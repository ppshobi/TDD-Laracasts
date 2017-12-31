<?php

namespace App\Inspections;

use Exception;

class InvalidKeywords
{
    private $keywords = [
        'yahoo customer support',
    ];

    public function detect($text)
    {
        foreach ($this->keywords as $keyWord)
        {
            throw_if(stripos($text, $keyWord) !== false, new Exception('Your Reply Contains Spam'));
        }
    }
}