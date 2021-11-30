<?php

namespace App\Form;

use App\Entity\ApCatalogFilesBp;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ApCatalogFilesBpType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            //->add('fileName')
            ->add('imageFile', VichFileType::class, [
                'required'      => false,
                'allow_delete'  => false, // not mandatory, default is true
                'download_uri' => false, // not mandatory, default is true
    ])
            // ->add('fileSize')
            // ->add('fileType')
            //  ->add('createdAt')
            // ->add('model')
            //  ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ApCatalogFilesBp::class,
        ]);
    }
}
