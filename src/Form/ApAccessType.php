<?php

namespace App\Form;

use App\Entity\ApAccess;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApAccessType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('_view')
            ->add('_add')
            ->add('_edit')
            ->add('_delete')
            ->add('tab', null, ['choice_label'=>'name'])
            ->add('role', null, ['choice_label'=>'name'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ApAccess::class,
            'role' => ApRole::class,
            'tab' => ApTab::class,
        ]);
    }
}
