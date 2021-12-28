<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('UserEmail')
            ->add('roles')
            ->add('password')
            ->add('username')
            ->add('UserFullName')
            ->add('UserAddress')
            ->add('UserPhone')
            ->add('UserDOB')
            ->add('CreateAt')
            ->add('CreateBy')
            ->add('UpdateAt')
            ->add('UpdateBy')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
