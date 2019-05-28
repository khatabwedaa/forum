<?php

namespace App;

class Spam 
{
    public function detect($body)
    {
        $this->detectInvalidKeyWords($body);

        return false;
    }

    public function detectInvalidKeyWords($body)
    {
        $invalidKeyWords = [
            'Hello oneee!'
        ];

        foreach ($invalidKeyWords as $keyWord) {
            if(stripos($body , $keyWord) !== false) {
                throw new \Exception('Your reply has spam');
            }
        }
    }
}