<?php

namespace App;

class Spam
{
    public function detect($text)
    {
        $this->detectInvalidKeywords($text);

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
}
