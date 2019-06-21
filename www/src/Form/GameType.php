<?php

namespace App\Form;

use App\Entity\Game;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('teamName', TextType::class, array(
                'attr' => array(
                    'style' => 'width: 250px',
                    'placeholder' => 'Team name')
            ))
            ->add('gameCoach' ,TextType::class ,array(
                'attr' => array(
                    'style' => 'width: 250px',
                    'placeholder' => 'Coach'),
                'label' => 'Coach'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
            'csrf_protection' => false,
            'allow_extra_fields' => true,
        ]);
    }
}
