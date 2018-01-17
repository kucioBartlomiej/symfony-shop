<?php

namespace AppBundle\Picture;

use AppBundle\Entity\Product;
use AppBundle\Entity\Picture;

class PictureFactory {
    
    public static function createFromProduct(Product $product): Picture
    {
        $picture = new Picture();
        $picture->createFromProduct($product);
        return $picture;
    }
    
    
}
