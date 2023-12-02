<?php

namespace App\Form;

use App\Entity\Annoncerecrutement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class AnnoncerecrutementType extends AbstractType
{
    public function buildForm (FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('postedemande')
            ->add('salairepropose')
            ->add('typecontrat',ChoiceType::class,[
            'choices' => [
      'CDD' => 'CDD',
      'CDI' => 'CDI', 
            ]
            ])
            
            ->add('localisation')
            ->add('nbposterecherche')
    



            ->add('dateembauche', DateType::class, [
                'widget' => 'single_text', // Utiliser le widget single_text pour afficher un champ de texte simple
                'attr' => ['class' => 'form-control'], // Ajouter des classes Bootstrap pour le style
            ])
            // ...
        ;
    }

 
   

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annoncerecrutement::class,
        ]);
    }
}
