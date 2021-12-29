<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Category;
use App\Entity\Author;
use App\Entity\Type;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('BookTitle', TextType::class, [
                'label' => 'Book Title',
                'required' => true,
                'attr' =>
                [
                    'maxlength' => 1000
                ]
            ])
            ->add('PublishedAt', DateType::class,
            [
                'widget' => 'single_text',
                'label' => 'Published Year',
                'required' => true,
            ])
            ->add('PublishedBy', TextType::class, [
                'label' => 'PublishedBy',
                'required' => false,
                'attr' =>
                [
                    'maxlength' => 1000
                ]
            ])
            ->add('BookQuantity', IntegerType::class,         
            [
                'label' => 'Book Quantity',
                'required' => true,
                'attr' =>
                [
                    'min' => 0,
                    'max' => 10000
                ]
            ])
            ->add('BookPrice', MoneyType::class,
            [
                'label' => 'Book Price',
                'required' => true,
                'currency' => 'USD'
            ])           
            ->add('Category', EntityType::class,
            [
                'label' => 'Book Category',
                'class' => Category::class,
                'choice_label' => 'CategoryName',
                'multiple' => true,
                'expanded' => false,
                'attr' => [
                    'class' => 'slt_type form-control'
                ]
            ])
            ->add('Author', EntityType::class,
            [
                'label' => 'Book Authors',
                'class' => Author::class,
                'choice_label' => 'AuthorFullName',
                'multiple' => true,
                'expanded' => false,
                'attr' => [
                    'class' => 'slt_type form-control'
                ]
            ])
            ->add('Type', EntityType::class,
            [
                'label' => 'Book Type',
                'class' => Type::class,
                'choice_label' => 'TypeName',
                'multiple' => true,
                'expanded' => false,
                'attr' => [
                    'class' => 'slt_type form-control'
                ]
            ])
            ->add('type_product', TextType::class, [
                'label' => 'Type Product',
                'required' => false,
                'attr' =>
                [
                    'maxlength' => 1000
                ]
            ])
            ->add('type_product', ChoiceType::class,
                [
                    'label' => 'Type Product',
                    'choices' => [
                        'New Product' =>  'NEW',
                        'Hot Product' => 'HOT',
                        'Seller Product' => 'SELLER',
                        'Normal Product' => 'NORMAL',
                        'Popular Product' => 'POPULAR',
                    ],
                    'attr' => [
                        'class' => 'radio-btn'
                    ],
                    'expanded' => true
                ])
            ->add('BookImage', FileType::class, [
                'data_class' => null,
                'label' => 'Book image',
                'required' => false,
                'attr' =>
                    [
                        'maxlength' => 255
                    ]
            ])
            ->add('BookSummary', TextareaType::class, [
                'label' => 'Book Summary',
                'required' => false,
                'attr' =>
                    [
                        'rows' => 5,
                        ''
                    ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
