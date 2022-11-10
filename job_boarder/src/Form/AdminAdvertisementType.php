<?php

namespace App\Form;

use App\Entity\Advertisement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminAdvertisementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if($options['add'] == true)
        {
            $builder
                // ->add('title', TextType::class)  
                ->add('titre')
                ->add('contract')
                ->add('domain')
                ->add('post')
                ->add('createdDate', DateType::class, [
                    "widget"=>"single_text"
                ])
                ->add('company')
            ;
        }
        elseif($options['update'] == true)
        {
            $builder
                // ->add('title', TextType::class)  
                ->add('titre')
                ->add('contract')
                ->add('domain')
                ->add('post')
                ->add('createdDate', DateType::class, [
                    "widget"=>"single_text"
                ])
                ->add('company')
            ;
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Advertisement::class,
            'add'=>false,
            'update'=>false
        ]);
    }
}
