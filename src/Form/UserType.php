<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('user_full_name', TextType::class, [
                    'required' => true,
                    'attr' => [
                        'maxlength' => 50,
                        'minlength' => 10,
                        'class' => 'form-control',
                        'placeholder' => 'Full name'
                    ]
                ])
                ->add('user_address', TextType::class, [
                    'required' => true,
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'Address'
                    ]
                ])
                ->add('user_phone', TextType::class, [
                    'required' => true,
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'Telephone'
                    ]
                ])
                ->add('user_DOB', DateType::class, [
                    'required' => true,
                    'widget' => 'single_text',
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'Birthday'
                    ]
                ])
                ->add('user_email', TextType::class, [
                    'required' => true,
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'Email'
                    ]
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
