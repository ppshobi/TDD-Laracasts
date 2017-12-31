<?php

namespace App\Inspections;

class Spam
{
    public function detect($text)
    {
        $this->detectInvalidKeywords($text);
        $this->detectKeyHeldDown($text);

        return false;
    }

    private function detectInvalidKeywords($text)
    {
        $invalidKeyWords = [
            'yahoo customer support',
        ];

        foreach ($invalidKeyWords as $keyWord)
        {
            throw_if(stripos($text, $keyWord) !== false, new \Exception('Your Reply Contains Spam'));
        }
    }

    private function detectKeyHeldDown($text)
    {
        throw_if(preg_match('/(.)\\1{4,}/',$text), new \Exception('Your Reply Contains Spam'));
    }
}
