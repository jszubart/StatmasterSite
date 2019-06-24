<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword', PasswordType::class, array(
                'attr' => array(
                    'style' => 'width: 250px',
                    'placeholder' => 'Old Password'),
            ))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'invalid_message' => 'Wrong passwords',
                'options' => array(
                    'attr' => array(
                        'class' => 'password-field'
                    )
                ),
                'required' => true,
                'first_options' => ['label' => ' New Password', 'attr' => array(
                    'style' => 'width: 250px; margin: auto',
                    'placeholder' => 'New Password')],
                'second_options' => ['label' => 'Repeat Password', 'attr' => array(
                    'style' => 'width: 250px; margin: auto',
                    'placeholder' => 'Repeat Password')]
            ))
            ->add('submit', SubmitType::class, array(
                'attr' => array(
                    'class' => 'btn btn-primary mt-2',
                )
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Form\Model\ChangePassword'
        ]);
    }
}