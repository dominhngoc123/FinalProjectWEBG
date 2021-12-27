<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'required' => true,
                'attr' => [
                    'maxlength' => 50,
                    'minlength' => 10,
                    'class' => 'form-control placeholder-no-fix',
                    'placeholder' => 'Username'
                ]
            ])
            ->add('user_full_name', TextType::class, [
                'required' => true,
                'attr' => [
                    'maxlength' => 50,
                    'minlength' => 10,
                    'class' => 'form-control placeholder-no-fix',
                    'placeholder' => 'Full name'
                ]
            ])
            ->add('user_address', TextType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'form-control placeholder-no-fix',
                    'placeholder' => 'Address'
                ]
            ])
            ->add('user_phone', TextType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'form-control placeholder-no-fix',
                    'placeholder' => 'Telephone'
                ]
            ])
            ->add('user_DOB', DateType::class, [
                'required' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control placeholder-no-fix',
                    'placeholder' => 'Birthday'
                ]
            ])
            ->add('user_email', TextType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'form-control placeholder-no-fix',
                    'placeholder' => 'Email'
                ]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'class' => 'form-control placeholder-no-fix',
                    'placeholder' => 'Password'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
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
