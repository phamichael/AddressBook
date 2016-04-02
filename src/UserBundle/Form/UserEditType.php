<?php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserEditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('nom')
            ->remove('prenom')
            ->remove('dateNaissance')
            ->remove('username')
            ->remove('password')
        ;
    }

    public function getParent()
    {
        return new UserType();
    }
}