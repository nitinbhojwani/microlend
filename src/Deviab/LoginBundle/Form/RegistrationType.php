<?php

namespace Deviab\LoginBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    }

    // public function getParent()
    // {
    //     return 'fos_user_registration';
    // }

    public function getName()
    {
        return 'deviab_user_registration';
    }
}