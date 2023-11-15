<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nomprod', null, [
            'label' => 'Nom du produit',
            'attr' => [
                'class' => 'form-control',
                'placeholder' => 'Nom du produit',
            ],
        ])
        
        ->add('cat', ChoiceType::class, [
            'label' => 'Catégorie',
            'attr' => [
                'class' => 'form-control',
                'placeholder' => 'Catégorie',
            ],
            'choices' => [
                'Feruit' => 'feruit',
                'Legume' => 'legume',
                
            ],
        ])
            ->add('prix')
            ->add('qte', null, [
                'label' => 'Quantité',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Quantité',
                ],
            ])
            ->add('descr', null, [
                'label' => 'Description',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Description',
                ],
            ])
            ->add('status')
            ->add('image', FileType::class, [
                'label' => 'Votre Image (JPG, JPEG, PNG file)',
                'mapped' => false,
                'required' => false,
                'attr' => ['accept' => 'image/*'],
            ])
            // ->add('save',SubmitType::class)
            
                   ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
