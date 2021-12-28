<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('CategoryName', TextType::class, [
                'label' => 'Category name',
                'required' => true,
                'attr' =>
                [
                    'maxlength' => 50
                ]
            ])
            ->add('CategoryDescription', TextareaType::class, [
                'label' => 'Category description',
                'required' => false,
                'attr' =>
                    [
                        'rows' => 5,
                        ''
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
            'data_class' => Category::class,
        ]);
    }
}
