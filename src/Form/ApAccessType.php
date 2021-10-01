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

        // $user = $options['user'];
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
                     
                
                // 'query_builder' => function(EntityRepository $er) use ($user)  {
                //         $qb = $er->createQueryBuilder('t')
                //         ->leftJoin('t.apAccesses', 'a','WITH', 't.id = a.tab')
                //         ->where( 'a.role = :role' );
                //     $queryBuilderComparaison = $er->createQueryBuilder('ta')
                //     ->where('ta.id' . ' not in (' . $qb->getDQL() . ')')
                //     ->orWhere('ta.id = :id')
                //     ->setParameter('role', $user);
                //     return $queryBuilderComparaison;
                // },
                'choice_label' => 'name',
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ApAccess::class,
        ]);
    }
}
