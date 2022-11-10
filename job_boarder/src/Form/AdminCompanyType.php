<?php

namespace App\Form;

use App\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminCompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if($options['add'] == true)
        {
            $builder
                ->add('name')
                ->add('city')
                ->add('email')
                ->add('phone')
                ->add('description')
                ->add('user')
            ;
        }
        elseif($options['update'])
        {
            $builder
                ->add('name')
                ->add('city')
                ->add('email')
                ->add('phone')
                ->add('description')
                ->add('user')
            ;
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
            'add'=>false,
            'update'=>false
        ]);
    }
}
