<?php

namespace App\Form;

use App\Entity\Bilanresultat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BilanresultatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('anneer')
            ->add('iduser')
            ->add('autrerevenus')
            ->add('subvention')
            ->add('revenuescultures')
            ->add('semences')
            ->add('coutmainoeuvre')
            ->add('coutinterventionmedicale')
            ->add('coutsplantations')
            ->add('chargeselectricite')
            ->add('chargeentretien')
            ->add('chargeadministratives')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bilanresultat::class,
        ]);
    }
}
