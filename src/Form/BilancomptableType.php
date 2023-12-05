<?php

namespace App\Form;

use App\Entity\Bilancomptable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BilancomptableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('iduser')
            ->add('annee')
            ->add('resultatnet')
            ->add('valeurterrain')
            ->add('materiels')
            ->add('autresimmobilisations')
            ->add('stocksproduits')
            ->add('creanceclient')
            ->add('tresorie')
            ->add('capitalsocial')
            ->add('reserves')
            ->add('emprunts')
            ->add('dettesct')
            ->add('dettesit')
            ->add('fournisseurs')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bilancomptable::class,
        ]);
    }
}
