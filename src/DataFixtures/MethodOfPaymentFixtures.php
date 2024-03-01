<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Payment;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class MethodOfPaymentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $payment = $this->createCB();
        $payment1 = $this->createPaypal();



        $manager->persist($payment);
        $manager->persist($payment1);




        $manager->flush();
    }

    private function createCB(): Payment
    {
        $payment = new Payment();
        $payment->settitle("Par Carte Bancaire");
        $payment->setImage("cartes-65df72d80543a605047373.jpg");
        $payment->setContent("Payez Par carte bancaire");
        return $payment;
    }

    private function createPaypal(): Payment
    {
        $payment1 = new Payment();
        $payment1->settitle("Par Paypal");
        $payment1->setImage("paypal-65df72eded1af694129323.jpg");
        $payment1->setContent("Payez Par Paypal");
        return $payment1;
    }
}
