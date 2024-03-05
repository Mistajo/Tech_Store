<?php

namespace App\DataFixtures;

use App\Entity\Image;

use App\Entity\Product;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PcBureauFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);


        $category = new Category();
        $category->setName("PC de Bureau");
        $category->setImage("Pc_de_bureau.png");
        $category->setDescription("Les meilleures performances pour le divertissement personnel et familial");

        $image2 = new Image();
        $image2->setName("7fdfa59482c1cadfb48ff5f892d6e589.jpg");
        $image1 = new Image();
        $image1->setName("60b453c47bc522f0996c98750f9722be.jpg");
        $image3 = new Image();
        $image3->setName("2728cc2ac299bb74f2ce7b9ee5e4bfe3.jpg");
        $image4 = new Image();
        $image4->setName("b25876c59d87e53af6526e43b756bca8.jpg");
        // $image5 = new Image();
        // $image5->setName("c4cd3ab1f52bcd8f0c3064739573dee6.jpg");
        // $image6 = new Image();
        // $image6->setName("c0090ac5b360f6a50470f3859d09601c.jpg");
        // $image7 = new Image();
        // $image7->setName("d0156983b506b53803f8fd4abf50d2bd.jpg");

        $image8 = new Image();
        $image8->setName("0141c16424623780c1a7e963d082ab95.jpg");
        $image9 = new Image();
        $image9->setName("a893164c43a37a20dcd72a32f740d477.jpg");
        // $image10 = new Image();
        // $image10->setName("46177113440d4d6564b038cc432ff36e.jpg");
        // $image11 = new Image();
        // $image11->setName("d9215a8a30496cb4c9266c3068223633.jpg");
        // $image12 = new Image();
        // $image12->setName("df917b5bbd94d03de302e305796d45f9.jpg");

        $image13 = new Image();
        $image13->setName("2fe85db25b69fd331b5c7323553b030f.jpg");
        $image14 = new Image();
        $image14->setName("9e83d80e6f62d0eaa33c75bf511c57cc.jpg");
        $image15 = new Image();
        $image15->setName("25337fbb7c379962361b813c69e0e8c6.jpg");
        $image16 = new Image();
        $image16->setName("fc43384f6ee67c7e00a410e98e582903.jpg");

        $image17 = new Image();
        $image17->setName("5a0c5781d642f8cdba49d155edeeda92.jpg");
        $image18 = new Image();
        $image18->setName("33ff18dffa127194b0c55726395f943e.jpg");
        $image19 = new Image();
        $image19->setName("a1c109065e50616c5e44bbd3965709ed.jpg");
        $image20 = new Image();
        $image20->setName("b94133036a58342fc5e74712a7f44f05.jpg");
        $image21 = new Image();
        $image21->setName("c649d949a3d737090bd1e2861b401b45.jpg");

        // $image22 = new Image();
        // $image22->setName("20ce8bad9ff24da29daddae6d94b589a.jpg");
        // $image23 = new Image();
        // $image23->setName("35a3116307bb67594f899aea4eaacff6.jpg");
        // $image24 = new Image();
        // $image24->setName("9550ca099225a8d6e6a629b8b302ebdd.jpg");

        // $image25 = new Image();
        // $image25->setName("0a346186eedc84953d12bc0ba8c501ac.jpg");
        // $image26 = new Image();
        // $image26->setName("201628cfcc308cb378fd4e3b57833b0b.jpg");
        // $image27 = new Image();
        // $image27->setName("c61459c7d979ec6e06a2ff19f3aa397a.jpg");
        // $image28 = new Image();
        // $image28->setName("cdec3e04188172a303eaa084c78c316b.jpg");




        $pcbureau = new Product();
        $pcbureau->addCategory($category);
        $pcbureau->setName("Lenovo Thinkcentre M720s SFF PC Ordinateur Intel i7-8700 Ram 16 Go DDR4 SSD 512 Go Wi-Fi Windows 10 Pro + Office 2021");
        $pcbureau->setPrice(374.90);
        $pcbureau->setStock(20);
        $pcbureau->setBrand("LENOVO");
        $pcbureau->setShortDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.");
        $pcbureau->setLongDescription("praesent elementum facilisis leo vel fringilla est ullamcorper eget nulla facilisi etiam dignissim diam quis enim lobortis scelerisque fermentum dui faucibus in ornare quam viverra orci sagittis eu volutpat odio facilisis mauris sit amet massa vitae tortor condimentum lacinia quis vel eros donec ac odio tempor orci dapibus ultrices in iaculis nunc sed augue lacus viverra vitae congue eu consequat ac felis donec et odio pellentesque diam volutpat commodo sed egestas egestas fringilla phasellus faucibus scelerisque eleifend donec pretium vulputate sapien nec sagittis aliquam malesuada bibendum arcu vitae elementum curabitur vitae nunc sed velit dignissim sodales ut eu sem integer vitae justo eget magna fermentum");
        $pcbureau->setRam(16);
        $pcbureau->setHardDisk(512);
        $pcbureau->addImage($image2);
        $pcbureau->addImage($image1);
        $pcbureau->addImage($image3);
        $pcbureau->addImage($image4);
        // $pcbureau->addImage($image5);
        // $pcbureau->addImage($image6);
        // $pcbureau->addImage($image7);
        $image1->setProduct($pcbureau);
        $image2->setProduct($pcbureau);
        $image3->setProduct($pcbureau);
        $image4->setProduct($pcbureau);
        // $image5->setProduct($pcbureau);
        // $image6->setProduct($pcbureau);
        // $image7->setProduct($pcbureau);

        $pcbureau1 = new Product();
        $pcbureau1->addCategory($category);
        $pcbureau1->setName("Station complète PC HP 8200 I5 3,1 GHz 8 Go RAM 240 Go SSD 10 ports USB Wi-Fi + moniteur HP E201 FHD clavier et souris");
        $pcbureau1->setPrice(189.00);
        $pcbureau1->setStock(20);
        $pcbureau1->setBrand("HP");
        $pcbureau1->setShortDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.");
        $pcbureau1->setLongDescription("praesent elementum facilisis leo vel fringilla est ullamcorper eget nulla facilisi etiam dignissim diam quis enim lobortis scelerisque fermentum dui faucibus in ornare quam viverra orci sagittis eu volutpat odio facilisis mauris sit amet massa vitae tortor condimentum lacinia quis vel eros donec ac odio tempor orci dapibus ultrices in iaculis nunc sed augue lacus viverra vitae congue eu consequat ac felis donec et odio pellentesque diam volutpat commodo sed egestas egestas fringilla phasellus faucibus scelerisque eleifend donec pretium vulputate sapien nec sagittis aliquam malesuada bibendum arcu vitae elementum curabitur vitae nunc sed velit dignissim sodales ut eu sem integer vitae justo eget magna fermentum");
        $pcbureau1->setRam(8);
        $pcbureau1->setHardDisk(240);
        $pcbureau1->addImage($image8);
        $pcbureau1->addImage($image9);
        // $pcbureau1->addImage($image10);
        // $pcbureau1->addImage($image11);
        // $pcbureau1->addImage($image12);

        $image8->setProduct($pcbureau1);
        $image9->setProduct($pcbureau1);
        // $image10->setProduct($pcbureau1);
        // $image11->setProduct($pcbureau1);
        // $image12->setProduct($pcbureau1);

        $pcbureau2 = new Product();
        $pcbureau2->addCategory($category);
        $pcbureau2->setName("HP 24-dp0005n 23.8 1920 x 1080 Pixels AMD Ryzen 3 4300U 8 GB DDR4-SDRAM 512 GB SSD PC All-in-One Windows 10 Home ");
        $pcbureau2->setPrice(683);
        $pcbureau2->setStock(10);
        $pcbureau2->setBrand("HP");
        $pcbureau2->setShortDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.");
        $pcbureau2->setLongDescription("praesent elementum facilisis leo vel fringilla est ullamcorper eget nulla facilisi etiam dignissim diam quis enim lobortis scelerisque fermentum dui faucibus in ornare quam viverra orci sagittis eu volutpat odio facilisis mauris sit amet massa vitae tortor condimentum lacinia quis vel eros donec ac odio tempor orci dapibus ultrices in iaculis nunc sed augue lacus viverra vitae congue eu consequat ac felis donec et odio pellentesque diam volutpat commodo sed egestas egestas fringilla phasellus faucibus scelerisque eleifend donec pretium vulputate sapien nec sagittis aliquam malesuada bibendum arcu vitae elementum curabitur vitae nunc sed velit dignissim sodales ut eu sem integer vitae justo eget magna fermentum");
        $pcbureau2->setRam(16);
        $pcbureau2->setHardDisk(512);
        $pcbureau2->addImage($image13);
        $pcbureau2->addImage($image14);
        $pcbureau2->addImage($image15);
        $pcbureau2->addImage($image16);

        $image13->setProduct($pcbureau2);
        $image14->setProduct($pcbureau2);
        $image15->setProduct($pcbureau2);
        $image16->setProduct($pcbureau2);

        $pcbureau3 = new Product();
        $pcbureau3->addCategory($category);
        $pcbureau3->setName("Apple 2023 iMac Ordinateur de Bureau Tout‑en‑Un avec Puce M3  CPU 8 cœurs, GPU 10 cœurs, écran Retina 4,5K 24 Pouces, 8 Go de mémoire unifiée, 256 Go de Stockage SSD, Bleu");
        $pcbureau3->setPrice(1635.99);
        $pcbureau3->setStock(8);
        $pcbureau3->setBrand("APPLE");
        $pcbureau3->setShortDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.");
        $pcbureau3->setLongDescription("praesent elementum facilisis leo vel fringilla est ullamcorper eget nulla facilisi etiam dignissim diam quis enim lobortis scelerisque fermentum dui faucibus in ornare quam viverra orci sagittis eu volutpat odio facilisis mauris sit amet massa vitae tortor condimentum lacinia quis vel eros donec ac odio tempor orci dapibus ultrices in iaculis nunc sed augue lacus viverra vitae congue eu consequat ac felis donec et odio pellentesque diam volutpat commodo sed egestas egestas fringilla phasellus faucibus scelerisque eleifend donec pretium vulputate sapien nec sagittis aliquam malesuada bibendum arcu vitae elementum curabitur vitae nunc sed velit dignissim sodales ut eu sem integer vitae justo eget magna fermentum");
        $pcbureau3->setRam(8);
        $pcbureau3->setHardDisk(256);
        $pcbureau3->addImage($image17);
        $pcbureau3->addImage($image18);
        $pcbureau3->addImage($image19);
        $pcbureau3->addImage($image20);
        $pcbureau3->addImage($image21);

        $image17->setProduct($pcbureau3);
        $image18->setProduct($pcbureau3);
        $image19->setProduct($pcbureau3);
        $image20->setProduct($pcbureau3);
        $image21->setProduct($pcbureau3);

        // $pcbureau4 = new Product();
        // $pcbureau4->addCategory($category);
        // $pcbureau4->setName("(2019) Apple MacBook Pro 13, Core i5 8Go 256Go SSD Retina Touch ID Touch Bar");
        // $pcbureau4->setPrice(739);
        // $pcbureau4->setStock(25);
        // $pcbureau4->setBrand("APPLE");
        // $pcbureau4->setShortDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.");
        // $pcbureau4->setLongDescription("praesent elementum facilisis leo vel fringilla est ullamcorper eget nulla facilisi etiam dignissim diam quis enim lobortis scelerisque fermentum dui faucibus in ornare quam viverra orci sagittis eu volutpat odio facilisis mauris sit amet massa vitae tortor condimentum lacinia quis vel eros donec ac odio tempor orci dapibus ultrices in iaculis nunc sed augue lacus viverra vitae congue eu consequat ac felis donec et odio pellentesque diam volutpat commodo sed egestas egestas fringilla phasellus faucibus scelerisque eleifend donec pretium vulputate sapien nec sagittis aliquam malesuada bibendum arcu vitae elementum curabitur vitae nunc sed velit dignissim sodales ut eu sem integer vitae justo eget magna fermentum");
        // $pcbureau4->setRam(8);
        // $pcbureau4->setHardDisk(256);
        // $pcbureau4->addImage($image22);
        // $pcbureau4->addImage($image23);
        // $pcbureau4->addImage($image24);

        // $image22->setProduct($pcbureau4);
        // $image23->setProduct($pcbureau4);
        // $image24->setProduct($pcbureau4);

        // $pcbureau5 = new Product();
        // $pcbureau5->addCategory($category);
        // $pcbureau5->setName("Apple 2022 MacBook Air avec Puce M2  écran Liquid Retina de 13,6 Pouces, 8GB de RAM, 256 Go de Stockage SSD ; Argent");
        // $pcbureau5->setPrice(1499.00);
        // $pcbureau5->setStock(15);
        // $pcbureau5->setBrand("APPLE");
        // $pcbureau5->setShortDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.");
        // $pcbureau5->setLongDescription("praesent elementum facilisis leo vel fringilla est ullamcorper eget nulla facilisi etiam dignissim diam quis enim lobortis scelerisque fermentum dui faucibus in ornare quam viverra orci sagittis eu volutpat odio facilisis mauris sit amet massa vitae tortor condimentum lacinia quis vel eros donec ac odio tempor orci dapibus ultrices in iaculis nunc sed augue lacus viverra vitae congue eu consequat ac felis donec et odio pellentesque diam volutpat commodo sed egestas egestas fringilla phasellus faucibus scelerisque eleifend donec pretium vulputate sapien nec sagittis aliquam malesuada bibendum arcu vitae elementum curabitur vitae nunc sed velit dignissim sodales ut eu sem integer vitae justo eget magna fermentum");
        // $pcbureau5->setRam(8);
        // $pcbureau5->setHardDisk(512);
        // $pcbureau5->addImage($image25);
        // $pcbureau5->addImage($image26);
        // $pcbureau5->addImage($image27);
        // $pcbureau5->addImage($image28);

        // $image25->setProduct($pcbureau5);
        // $image26->setProduct($pcbureau5);
        // $image27->setProduct($pcbureau5);
        // $image28->setProduct($pcbureau5);

        $manager->persist($category);
        $manager->persist($pcbureau);
        $manager->persist($pcbureau1);
        $manager->persist($pcbureau2);
        $manager->persist($pcbureau3);
        // $manager->persist($pcbureau4);
        // $manager->persist($pcbureau5);
        $manager->persist($image1);
        $manager->persist($image2);
        $manager->persist($image3);
        $manager->persist($image4);
        // $manager->persist($image5);
        // $manager->persist($image6);
        // $manager->persist($image7);
        $manager->persist($image8);
        $manager->persist($image9);
        // $manager->persist($image10);
        // $manager->persist($image11);
        // $manager->persist($image12);
        $manager->persist($image13);
        $manager->persist($image14);
        $manager->persist($image15);
        $manager->persist($image16);
        $manager->persist($image17);
        $manager->persist($image18);
        $manager->persist($image19);
        $manager->persist($image20);
        $manager->persist($image21);



        $manager->flush();
    }
}