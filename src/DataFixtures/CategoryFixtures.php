<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);


        $category1 = $this->createPcBureau();
        $category2 = $this->createEcrans();
        $category3 = $this->createImprimantes();
        $category4 = $this->createEncreToner();
        $category5 = $this->createSouris();
        $category6 = $this->createClaviers();
        $category7 = $this->createPapiers();



        $manager->persist($category1);
        $manager->persist($category2);
        $manager->persist($category3);
        $manager->persist($category4);
        $manager->persist($category5);
        $manager->persist($category6);
        $manager->persist($category7);



        $manager->flush();
    }


    private function createPcBureau(): Category
    {
        $category1 = new Category();
        $category1->setName("PC de Bureau");
        $category1->setImage("Pc_de_bureau.png");
        $category1->setDescription("Les meilleures performances pour le divertissement personnel et familial");
        return $category1;
    }

    private function createEcrans(): Category
    {
        $category2 = new Category();
        $category2->setName("Ecrans");
        $category2->setImage("Ecran.png");
        $category2->setDescription("Atteignez le palier supplémentaire en ajoutant un écran");
        return $category2;
    }

    private function createImprimantes(): Category
    {
        $category3 = new Category();
        $category3->setName("Imprimantes");
        $category3->setImage("imprimante.png");
        $category3->setDescription("Imprimez comme vous voulez et économisez");
        return $category3;
    }

    private function createEncreToner(): Category
    {
        $category4 = new Category();
        $category4->setName("Encres et Toners");
        $category4->setImage("encre_toner.jpg");
        $category4->setDescription("Trouvez les cartouches qu'il vous faut");
        return $category4;
    }

    private function createSouris(): Category
    {
        $category5 = new Category();
        $category5->setName("Souris");
        $category5->setImage("Souris.jpg");
        $category5->setDescription("Trouvez les souris qu'il vous faut");
        return $category5;
    }

    private function createClaviers(): Category
    {
        $category6 = new Category();
        $category6->setName("Claviers");
        $category6->setImage("Claviers.jpg");
        $category6->setDescription("Trouvez les claviers qu'il vous faut");
        return $category6;
    }

    private function createPapiers(): Category
    {
        $category7 = new Category();
        $category7->setName("Papiers");
        $category7->setImage("Papier.jpg");
        $category7->setDescription("Trouvez le pour vos imprimantes");
        return $category7;
    }
}
