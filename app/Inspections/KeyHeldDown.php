<?php

namespace App\Inspections;

class KeyHeldDown 
{

     /**
     * Detect spam.
     *
     * @param  string $body
     *
     * @throws \Exception
     */
    public function detect($body)
    {
        if (preg_match('/(.)\\1{4,}/', $body)) {
            throw new \Exception('Your reply has spam');            
        }
    }
}