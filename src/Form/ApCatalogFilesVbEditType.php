<?php

namespace App\Form;

use App\Entity\ApCatalogFilesVb;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ApCatalogFilesVbEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('imageFile', VichFileType::class, [            
                'required'      => false,
                'allow_delete'  => false, // not mandatory, default is true
                'download_uri' => false, // not mandatory, default is true
    ])
            // ->add('archive')
            // ->add('file_name')
            // ->add('file_size')
            // ->add('file_type')
            // ->add('created_at')
            // ->add('user')
            // ->add('caseId')
            // ->add('sector')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ApCatalogFilesVb::class,
        ]);
    }
}
