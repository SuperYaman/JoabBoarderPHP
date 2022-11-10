<?php

namespace App\Form;

use App\Entity\NotUserApply;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NotUserApplyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if($options['add'] == true)
        {
            $builder
                ->add('name')
                ->add('firstName')
                ->add('email')
                ->add('city')
                ->add('phone')
                ->add('message')
                // ->add('advertisement')
            ;
        }
        elseif($options['update'])
        {
            $builder
                ->add('name')
                ->add('firstName')
                ->add('email')
                ->add('city')
                ->add('phone')
                ->add('message')
                ->add('advertisement')
                ->add('Save', SubmitType::class)
            ;
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NotUserApply::class,
            'add'=>false,
            'update'=>false
        ]);
    }
}
