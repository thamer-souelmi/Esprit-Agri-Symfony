<?php

namespace App\Form;

use App\Entity\Annonceinvestissement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnonceinvestissementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('montant')
            ->add('datepublication')
            ->add('localisation')
            ->add('description')
            ->add('photo')
            ->add('iduser')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonceinvestissement::class,
        ]);
    }
}
