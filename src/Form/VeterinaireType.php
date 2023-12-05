<?php

namespace App\Form;

use App\Entity\Veterinaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VeterinaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomvet')
            ->add('prenomvet')
            ->add('adresscabinet')
            ->add('numtel')
            ->add('adressmail')
            
            ->add('specialite',FileType::class, [
                'label' => 'Votre Image (JPG, JPEG, PNG file)',
                'mapped' => false,
                'required' => false,
                'attr' => ['accept' => 'image/*'],
            ])
        
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Veterinaire::class,
        ]);
    }
}
