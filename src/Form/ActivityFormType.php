<?php

namespace App\Form;

use App\Entity\Activity;
use App\Entity\ActivityType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivityFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'attr' => ['class' => 'js-datepicker', 'placeholder' => 'dd-mm-yyyy'],
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd-MM-yyyy'
            ])
            ->add('time', TimeType::class, [
                'attr' => ['class' => 'js-timepicker', 'placeholder' => 'hh:mm'],
                'widget' => 'single_text',
                'html5' => false,
            ])
            ->add('activityType', EntityType::class, [
                    'class' => ActivityType::class,
                    'choice_label' => 'naam',
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Activity::class,
        ]);
    }
}
