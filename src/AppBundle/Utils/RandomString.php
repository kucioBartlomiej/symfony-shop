<?php

namespace AppBundle\Utils;

class RandomString {
    
    static public function generate(): string
    {
        return md5(uniqid());
    }
    
}
