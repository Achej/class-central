<?php

namespace ClassCentral\SiteBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CourseType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('name')
            ->add('description', null, array('required'=>false))
            ->add('shortName',null, array('required'=>false))

            ->add('stream', 'entity', array(
                'class' => 'ClassCentralSiteBundle:Stream',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.name', 'ASC')->where('s.showInNav = 1');
                },
            ))

            ->add('initiative', 'entity', array(
                'required'=>false,
                'empty_value' => true,
                'class' => 'ClassCentralSiteBundle:Initiative',
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('i')->orderBy('i.name','ASC');
                }
             ))

            ->add('institutions', null, array(
                'required'=>false,
                'empty_value'=>true,
                'class' => 'ClassCentralSiteBundle:Institution',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('i')->orderBy('i.name','ASC');
                }
            ))
            ->add('language',null,array('required'=>false,'empty_value' => true))
            ->add('url')
            ->add('videoIntro')
            ->add('length')

            ->add('instructors', null, array(
                'required'=>false,
                'empty_value'=>true,
                'class' => 'ClassCentralSiteBundle:Instructor',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('i')->orderBy('i.id','DESC');
                }
            ))

            ->add('searchDesc')
        ;
       
      
    }

    public function getName() {
        return 'classcentral_sitebundle_coursetype';
    }
        
}
