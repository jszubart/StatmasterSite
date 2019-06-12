<?php

namespace App\Form;

use App\Entity\Game;
use App\Entity\GameStatistic;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameStatisticType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('playerName')
            ->add('eventName')
            ->add('score')
            ->add('game')
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GameStatistic::class,
            'csrf_protection' => false,
            'allow_extra_fields' => true,
        ]);
    }
}
