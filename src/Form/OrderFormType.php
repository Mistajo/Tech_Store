<?php

namespace App\Form;

use App\Entity\Addresses;
use App\Entity\Carrier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('addresses', EntityType::class, [
                'class' => Addresses::class,
                'label' => false,
                'required' => true,
                'multiple' => false,
                'expanded' => true,

            ])
            ->add('carriers', EntityType::class, [
                'class' => Carrier::class,
                'label' => false,
                'required' => true,
                'multiple' => false,
                'expanded' => true,

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'addresses' => [],
            'carriers' => [],

        ]);
    }
}
