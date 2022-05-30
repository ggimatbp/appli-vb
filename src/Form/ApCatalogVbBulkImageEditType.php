<?php

namespace App\Form;

use App\Entity\ApCatalogVbBulkImage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ApCatalogVbBulkImageEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('name')
            // ->add('archive')
            // ->add('file_name')
            // ->add('file_size')
            // ->add('file_type')
            // ->add('created_at')
            // ->add('user')
            // ->add('caseIs')
            ->add('miniature')
            ->add('name')
            ->add('imageFile', VichFileType::class, [            
                'required'      => false,
                'allow_delete'  => false, // not mandatory, default is true
                'download_uri' => false, // not mandatory, default is true
    ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ApCatalogVbBulkImage::class,
        ]);
    }
}
