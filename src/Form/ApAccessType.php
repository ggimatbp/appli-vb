<?php

namespace App\Form;

use App\Form\SCOPE_IDENTITY;
use App\Entity\ApTab;
use App\Repository\ApTabRepository;
use App\Repository\ApAccessRepository;
use App\Entity\ApAccess;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class ApAccessType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $user = $options['user'];
        var_dump($user);
        $builder
            ->add('_view')
            ->add('_add')
            ->add('_edit')
            ->add('_delete')
            ->add('id', HiddenType::class)
            ->add('tab', EntityType::class, [
                // 'class' => ApAccess::class,
                // 'query_builder' => function(entityRepository $er) {
                //     return $this->$er->createQueryBuilder('');
                // },
                'class' => ApTab::class,
                
                'query_builder' => function(ApTabRepository $repository) use ($user)  {  
                     return $repository->getTabByRole($user);
                        // $er->createQueryBuilder('t')
                        // ->addSelect('(SELECT ap_access.tab_id FROM ap_access WHERE ap_access.role_id = 18)')
                        //  ->where( 'a.id = ap_access.tab_id' );
                        //  ->setParameter('role', $user)
                        // ->orderBy('tab.id', 'ASC');
                        // $er->andWhere($er->expr()->in('ap_access.tab_id'));
                },
                'choice_label' => 'name',
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ApAccess::class,
            'user' => null,
        ]);
    }
}
