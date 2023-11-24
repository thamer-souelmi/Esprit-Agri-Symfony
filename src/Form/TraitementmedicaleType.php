<?php

namespace App\Form;

use App\Entity\Traitementmedicale;
use App\Entity\Veterinaire;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TraitementmedicaleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numero')
            ->add('typeintervmed' , ChoiceType::class,['choices'=> ['vaccination'=>'v','ExaminDeSante'=>'e' , 'AnalyseLaboratoire'=>'a' ,'churigie'=>'c' , 'autre'=>'r'],
            ])
            ->add('dateintervmed')
            ->add('coutinterv')
            ->add('medicament')
            ->add('dureetraitement')
            ->add('description')
            ->add('idvet',EntityType::class,[ 'class'=>Veterinaire::class, 'choice_label'=>'prenomvet','expanded'=>false,'multiple'=>false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Traitementmedicale::class,
        ]);
    }
}
