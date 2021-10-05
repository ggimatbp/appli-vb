<?php

namespace App\Form;

use App\Entity\ApAccess;
use App\Entity\ApRole;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class ApRoleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // $user = $options['user'];
        $builder
            ->add('name')
            
            ;


        // $builder
        //     ->add('apaccesses', CollectionType::class, [
        //         'entry_type' => ApAccessType::class,
        //         'entry_options' => ['label' => false],              
        //     ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ApRole::class,
            // 'user' => null,
        ]);
    }
}
