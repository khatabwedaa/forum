<?php 

namespace App\Inspections;

use Exception;

class InvalidKeyWords
{

    /**
     * All registered InvalidKeyWords
     * 
     * @var array
     */
    protected $keyWords = [
        'Hello oneee!'
    ];

    /**
     * Detect spam.
     *
     * @param  string $body
     *
     * @throws \Exception
     */
    public function detect($body)
    {
        foreach ($this->keyWords as $keyWord) {
            if(stripos($body , $keyWord) !== false) {
                throw new Exception('Your reply has spam');
            }
        }
    }
}