<?php

namespace App\Form;

use App\Entity\Annonceinvestissement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

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
            ->add('photo', FileType::class, [
                'label' => 'Upload an image',
                'mapped' => false, // To prevent the form from trying to set this as a property on your entity
                'required' => false, // Allow the field to be optional
            ])
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
