<?php

namespace App\Form;

use App\Entity\Image;
use App\Entity\Product;
use App\Entity\Category;
use App\Entity\SubCategory;
use App\Repository\SubCategoryRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ProductFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options,): void
    {


        $builder
            ->add('category', EntityType::class, [
                // looks for choices from this entity
                'class' => Category::class,

                'choice_label' => 'name',

                'multiple' => true,
            ])
            ->add('images', FileType::class, [
                'multiple' => true,
                'mapped' => false,
            ])

            ->add('price', MoneyType::class, [
                'currency' => 'EUR',
            ])
            ->add('name', TextType::class)
            ->add('brand', TextType::class)
            ->add('ram', NumberType::class)
            ->add('hardDisk', NumberType::class)
            ->add('stock', NumberType::class)
            ->add('shortDescription', TextareaType::class)
            ->add('longDescription', TextareaType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
