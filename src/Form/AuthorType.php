<?php

namespace App\Form;

use App\Entity\Author;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('AuthorFullName', TextType::class, [
                'label' => 'Author name',
                'required' => true,
                'attr' =>
                [
                    'maxlength' => 50
                ]
            ])
            ->add('AuthorStageName', TextType::class, [
                'label' => 'Author stage name',
                'required' => true,
                'attr' =>
                    [
                        'maxlength' => 50
                    ]
            ])
            ->add('AuthorImage', FileType::class, [
                'data_class' => null,
                'label' => 'Author image',
                'required' => false,
                'attr' =>
                    [
                        'maxlength' => 255
                    ]
            ])
            ->add('AuthorDescription', TextareaType::class, [
                'label' => 'Author description',
                'required' => false,
                'attr' =>
                    [
                        'rows' => 5,
                    ]
            ])
            ->add('AuthorGender', ChoiceType::class, [
                'label' => 'Author gender',
                'choices' => [
                    'Male' => 'Male',
                    'Female' => 'Female',
                ],
                'multiple' => false,
                'expanded' => false,
                
            ])
            ->add('AuthorDOB', DateType::class, [
                'label' => 'Author DOB',
                'widget'=> 'single_text',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Author::class,
        ]);
    }
}
