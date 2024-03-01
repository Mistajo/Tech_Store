<?php

namespace App\DataFixtures;

use App\Entity\Carrier;
use App\Entity\Category;
use App\Entity\Payment;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CarrierFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $carrier = $this->createColissimo();
        $carrier1 = $this->createTNT();



        $manager->persist($carrier);
        $manager->persist($carrier1);




        $manager->flush();
    }

    private function createColissimo(): Carrier
    {
        $carrier = new Carrier();
        $carrier->setName("Colissimo");
        $carrier->setPrice(4.99);
        $carrier->setImage("png-colissimo-icon-350x350-65df7253ca4c2290696986.png");
        $carrier->setContent("Livraison entre 3 Et 5 Jours");
        return $carrier;
    }

    private function createTNT(): Carrier
    {
        $carrier1 = new Carrier();
        $carrier1->setName("TNT");
        $carrier1->setPrice(9.99);
        $carrier1->setImage("TNT.jpg");
        $carrier1->setContent("Livraison entre 1 Et 2 Jours");
        return $carrier1;
    }
}
