<?php

namespace App\Form;

use App\Entity\ApInformationFiles;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ApInformationFilesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name')
            ->add('imageFile', VichFileType::class, [            
                'required'      => true,
                'allow_delete'  => false, // not mandatory, default is true
                'download_uri' => false, // not mandatory, default is true
    ])
            //->add('FileName')
            //->add('FileSize')
            //->add('FileType')
            //->add('created_at')
            //->add('state')
            //->add('Archive')
            // ->add('Section')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ApInformationFiles::class,
        ]);
    }
}
