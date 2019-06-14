<?php

namespace App\Form;

use App\Entity\Game;
use App\Entity\GameEvent;
use App\Entity\GameStatistic;
use Doctrine\ORM\EntityRepository;
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
            ->add('gameEvent', EntityType::class, array(
                'class' => GameEvent::class,
                'attr' => array('style' => 'width: 175px'),
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                },
                    'choice_label' => 'name',)
            )
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
