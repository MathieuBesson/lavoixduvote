<?php

namespace App\Form;

use App\Entity\Action;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('importance')
            ->add('theme')
            ->add('programs')
            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
                $program_id = $event->getForm()->getParent()->getParent()->getNormData()->getId();
                $event->setData(array_merge($event->getData(), ['programs' => (string) $program_id]));
            });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Action::class,
        ]);
    }
}
