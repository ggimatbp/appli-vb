<?php

namespace App\Form;

use App\Entity\ApRole;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;

class ApRoleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('variation', ButtonType::class, [
                'attr' => ['class' => 'btn btn-success btn-pos', 'data-collection-holder-class' => 'variations'],
                'label' => 'Ajouter une variation'
            ])
            ->add('apAccesses', CollectionType::class, [
                'entry_type' => ApAccessType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ApRole::class,
        ]);
    }
}
