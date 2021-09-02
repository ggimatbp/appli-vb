<?php

namespace App\Form;

use App\Entity\ApEmployee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApEmployeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('email')
            ->add('password')
            ->add('notification')
            ->add('active')
            ->add('checkin')
            ->add('hour_count')
            ->add('weekly_hour')
            ->add('Role', null, ['choice_label'=>'name'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ApEmployee::class,
            'role' => ApRole::class,
        ]);
    }
}
