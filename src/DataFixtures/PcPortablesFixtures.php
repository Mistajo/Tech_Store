<?php

namespace App\DataFixtures;

use App\Entity\Image;
use App\Entity\Carrier;
use App\Entity\Product;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PcPortablesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);


        $category = new Category();
        $category->setName("PC Portables");
        $category->setImage("Pc_Portables.png");
        $category->setDescription("Surfez sur internet, regardez des vidéos et des films, jouez à des jeux !");

        $image2 = new Image();
        $image2->setName("7d90d5b1ddd50b381b74f47cf390dcaa.jpg");
        $image1 = new Image();
        $image1->setName("7421ba0778a91716e6e5c64f5956ee18.jpg");
        $image3 = new Image();
        $image3->setName("a475c9a61deea9389813454f2b85347a.jpg");
        $image4 = new Image();
        $image4->setName("bfa7543d63be4af8342a5f9194140b89.jpg");
        $image5 = new Image();
        $image5->setName("c4cd3ab1f52bcd8f0c3064739573dee6.jpg");
        $image6 = new Image();
        $image6->setName("c0090ac5b360f6a50470f3859d09601c.jpg");
        $image7 = new Image();
        $image7->setName("d0156983b506b53803f8fd4abf50d2bd.jpg");

        $image8 = new Image();
        $image8->setName("17b69a0c7db26bc70a22f3f08ebd80d6.jpg");
        $image9 = new Image();
        $image9->setName("155c6ce4a7dc6c1161159c0495ff2d42.jpg");
        $image10 = new Image();
        $image10->setName("46177113440d4d6564b038cc432ff36e.jpg");
        $image11 = new Image();
        $image11->setName("d9215a8a30496cb4c9266c3068223633.jpg");
        $image12 = new Image();
        $image12->setName("df917b5bbd94d03de302e305796d45f9.jpg");

        $image13 = new Image();
        $image13->setName("5c3994265607ecb1c082509f23bc7219.jpg");
        $image14 = new Image();
        $image14->setName("3063d54066e52496a83777d1cb428460.jpg");
        $image15 = new Image();
        $image15->setName("3281936d81943b614cd438c9e0f64dbf.jpg");
        $image16 = new Image();
        $image16->setName("fe1c6a284a9672cc19efbd6b141f1571.jpg");

        $image17 = new Image();
        $image17->setName("1a91168e3fa760d63d2934e33ab4f9a3.jpg");
        $image18 = new Image();
        $image18->setName("5bd02a8a40a94c67369c254d87586f42.jpg");
        $image19 = new Image();
        $image19->setName("30ad59715b24c891f8a96031a8a58487.jpg");
        $image20 = new Image();
        $image20->setName("60dedf7002daa02bd1a44e93f471c7cf.jpg");
        $image21 = new Image();
        $image21->setName("943fdeb298dace104eb401c1fad2dcaa.jpg");



        $pcportable = new Product();
        $pcportable->addCategory($category);
        $pcportable->setName("HP 15S-EQ1334NG");
        $pcportable->setPrice(513);
        $pcportable->setStock(20);
        $pcportable->setBrand("HP");
        $pcportable->setShortDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.");
        $pcportable->setLongDescription("praesent elementum facilisis leo vel fringilla est ullamcorper eget nulla facilisi etiam dignissim diam quis enim lobortis scelerisque fermentum dui faucibus in ornare quam viverra orci sagittis eu volutpat odio facilisis mauris sit amet massa vitae tortor condimentum lacinia quis vel eros donec ac odio tempor orci dapibus ultrices in iaculis nunc sed augue lacus viverra vitae congue eu consequat ac felis donec et odio pellentesque diam volutpat commodo sed egestas egestas fringilla phasellus faucibus scelerisque eleifend donec pretium vulputate sapien nec sagittis aliquam malesuada bibendum arcu vitae elementum curabitur vitae nunc sed velit dignissim sodales ut eu sem integer vitae justo eget magna fermentum");
        $pcportable->setRam(8);
        $pcportable->setHardDisk(512);
        $pcportable->addImage($image2);
        $pcportable->addImage($image1);
        $pcportable->addImage($image3);
        $pcportable->addImage($image4);
        $pcportable->addImage($image5);
        $pcportable->addImage($image6);
        $pcportable->addImage($image7);
        $image1->setProduct($pcportable);
        $image2->setProduct($pcportable);
        $image3->setProduct($pcportable);
        $image4->setProduct($pcportable);
        $image5->setProduct($pcportable);
        $image6->setProduct($pcportable);
        $image7->setProduct($pcportable);

        $pcportable1 = new Product();
        $pcportable1->addCategory($category);
        $pcportable1->setName("HP Laptop 15S-FQ0001SF");
        $pcportable1->setPrice(277.42);
        $pcportable1->setStock(30);
        $pcportable1->setBrand("HP");
        $pcportable1->setShortDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.");
        $pcportable1->setLongDescription("praesent elementum facilisis leo vel fringilla est ullamcorper eget nulla facilisi etiam dignissim diam quis enim lobortis scelerisque fermentum dui faucibus in ornare quam viverra orci sagittis eu volutpat odio facilisis mauris sit amet massa vitae tortor condimentum lacinia quis vel eros donec ac odio tempor orci dapibus ultrices in iaculis nunc sed augue lacus viverra vitae congue eu consequat ac felis donec et odio pellentesque diam volutpat commodo sed egestas egestas fringilla phasellus faucibus scelerisque eleifend donec pretium vulputate sapien nec sagittis aliquam malesuada bibendum arcu vitae elementum curabitur vitae nunc sed velit dignissim sodales ut eu sem integer vitae justo eget magna fermentum");
        $pcportable1->setRam(4);
        $pcportable1->setHardDisk(128);
        $pcportable1->addImage($image8);
        $pcportable1->addImage($image9);
        $pcportable1->addImage($image10);
        $pcportable1->addImage($image11);
        $pcportable1->addImage($image12);

        $image8->setProduct($pcportable1);
        $image9->setProduct($pcportable1);
        $image10->setProduct($pcportable1);
        $image11->setProduct($pcportable1);
        $image12->setProduct($pcportable1);

        $pcportable2 = new Product();
        $pcportable2->addCategory($category);
        $pcportable2->setName("Dell XPS 15 9530 Intel Core i7-13700H Ordinateur Portable 15.6 FHD+ Silver Black 16 Go de RAM SSD 512Go Intel Arc A370M Graphics Win 11 Home Clavier Azerty ");
        $pcportable2->setPrice(1599);
        $pcportable2->setStock(25);
        $pcportable2->setBrand("DELL");
        $pcportable2->setShortDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.");
        $pcportable2->setLongDescription("praesent elementum facilisis leo vel fringilla est ullamcorper eget nulla facilisi etiam dignissim diam quis enim lobortis scelerisque fermentum dui faucibus in ornare quam viverra orci sagittis eu volutpat odio facilisis mauris sit amet massa vitae tortor condimentum lacinia quis vel eros donec ac odio tempor orci dapibus ultrices in iaculis nunc sed augue lacus viverra vitae congue eu consequat ac felis donec et odio pellentesque diam volutpat commodo sed egestas egestas fringilla phasellus faucibus scelerisque eleifend donec pretium vulputate sapien nec sagittis aliquam malesuada bibendum arcu vitae elementum curabitur vitae nunc sed velit dignissim sodales ut eu sem integer vitae justo eget magna fermentum");
        $pcportable2->setRam(16);
        $pcportable2->setHardDisk(512);
        $pcportable2->addImage($image13);
        $pcportable2->addImage($image14);
        $pcportable2->addImage($image15);
        $pcportable2->addImage($image16);

        $image13->setProduct($pcportable2);
        $image14->setProduct($pcportable2);
        $image15->setProduct($pcportable2);
        $image16->setProduct($pcportable2);


        $pcportable3 = new Product();
        $pcportable3->addCategory($category);
        $pcportable3->setName("Dell Inspiron 14 5430 Ordinateur Portable, Processeur Intel Core i5-1335U, Écran 14 1610 FHD+, 8Go RAM, 512Go SSD, Graphique Intel Iris XE, Windows 11 ");
        $pcportable3->setPrice(575.83);
        $pcportable3->setStock(25);
        $pcportable3->setBrand("DELL");
        $pcportable3->setShortDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.");
        $pcportable3->setLongDescription("praesent elementum facilisis leo vel fringilla est ullamcorper eget nulla facilisi etiam dignissim diam quis enim lobortis scelerisque fermentum dui faucibus in ornare quam viverra orci sagittis eu volutpat odio facilisis mauris sit amet massa vitae tortor condimentum lacinia quis vel eros donec ac odio tempor orci dapibus ultrices in iaculis nunc sed augue lacus viverra vitae congue eu consequat ac felis donec et odio pellentesque diam volutpat commodo sed egestas egestas fringilla phasellus faucibus scelerisque eleifend donec pretium vulputate sapien nec sagittis aliquam malesuada bibendum arcu vitae elementum curabitur vitae nunc sed velit dignissim sodales ut eu sem integer vitae justo eget magna fermentum");
        $pcportable3->setRam(8);
        $pcportable3->setHardDisk(512);
        $pcportable3->addImage($image17);
        $pcportable3->addImage($image18);
        $pcportable3->addImage($image19);
        $pcportable3->addImage($image20);
        $pcportable3->addImage($image21);

        $image17->setProduct($pcportable3);
        $image18->setProduct($pcportable3);
        $image19->setProduct($pcportable3);
        $image20->setProduct($pcportable3);
        $image21->setProduct($pcportable3);



        $manager->persist($category);
        $manager->persist($pcportable);
        $manager->persist($pcportable1);
        $manager->persist($pcportable2);
        $manager->persist($pcportable3);
        $manager->persist($image1);
        $manager->persist($image2);
        $manager->persist($image3);
        $manager->persist($image4);
        $manager->persist($image5);
        $manager->persist($image6);
        $manager->persist($image7);
        $manager->persist($image8);
        $manager->persist($image9);
        $manager->persist($image10);
        $manager->persist($image11);
        $manager->persist($image12);
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