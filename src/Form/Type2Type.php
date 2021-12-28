<?php

namespace App\Form;

use App\Entity\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Type2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        
            ->add('TypeName', TextType::class, [
                'label' => 'Type name',
                'required' => true,
                'attr' =>
                [
                    'maxlength' => 50
                ]
            ])
            ->add('TypeDescription', TextType::class, [
                'label' => 'Type name',
                'required' => true,
                'attr' =>
                [
                        'maxlength' => 50
                ]
            ])
            // ->add('CreateAt')
            // ->add('CreateBy')
            // ->add('UpdateAt')
            // ->add('UpdateBy')
            // ->add('books')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Type::class,
        ]);
    }
}
