<?php

namespace App\Form;

use App\Entity\Annoncerecrutement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnoncerecrutementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
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
            ->add('datepub')
            ->add('localisation')
            ->add('dateembauche')
            ->add('nbposterecherche')
        ;
    }
 
   

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annoncerecrutement::class,
        ]);
    }
}
