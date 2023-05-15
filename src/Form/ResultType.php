<?php

namespace App\Form;

use App\Entity\Result;
use App\Entity\Athlete;
use App\Entity\Discipline;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ResultType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date')
            ->add('outcome')
            ->add('athlete', EntityType::class, [
                'class' => Athlete::class,
                'choice_label' => 'name',])
            ->add('discipline', EntityType::class, [
                'class' => Discipline::class,
                'choice_label' => 'name',])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Result::class,
        ]);
    }
}
