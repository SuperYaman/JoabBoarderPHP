<?php

namespace App\Form;

use App\Entity\UserAdvertisement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminApplyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if($options['add'] == true)
        {
            $builder
                ->add('message')
                ->add('user')
                ->add('advertisement')
            ;
        }
        elseif($options['update'])
        {
            $builder
                ->add('message')
                ->add('user')
                ->add('advertisement')
                ->add('Edit', SubmitType::class)
            ;
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserAdvertisement::class,
        ]);
    }
}
