<?php

namespace ClassCentral\SiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class StreamType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('slug')
            ->add('showInNav',null,array('required'=>false))
        ;
    }

    public function getName()
    {
        return 'classcentral_sitebundle_streamtype';
    }
}
