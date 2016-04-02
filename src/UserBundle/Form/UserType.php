<?php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',                        'text')
            ->add('prenom',                     'text')
            ->add('dateNaissance',              'date')
            ->add('adresse',                    'textarea')
            ->add('email',                      'email')
            ->add('telephone',                  'text')
            ->add('site',                       'text', array('required' => false))
            ->add('username',                   'text')
            ->add('password',                   'password')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UserBundle\Entity\User'
        ));
    }
}
