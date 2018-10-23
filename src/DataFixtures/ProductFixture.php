<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixture extends BaseFixture
{
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(7, 'main_products', function($i) {
            $product = new Product();
            $product->setName(sprintf('Product%d', $i));
            $product->setPrice(mt_rand(10, 1000));
            $product->setDescription($this->faker->text);            
            
            return $product;
        });
        
        $manager->flush();
    }
}
