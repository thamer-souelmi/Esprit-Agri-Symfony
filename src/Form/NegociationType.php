<?php

namespace App\Form;

use App\Entity\Negociation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NegociationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('montantpropose')
            ->add('message')
            ->add('datenegociation')
            /*->add('etatnego',ChoiceType::class,[
                'choices'=>[
                    'ACCEPTEE'=>'ACCEPTEE',
                    'REFUSEE'=>'REFUSEE',
                ],
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Negociation::class,
        ]);
    }
}
