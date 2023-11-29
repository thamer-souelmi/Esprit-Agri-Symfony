<?php

namespace App\Form;

use App\Entity\Annoncerecrutement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotNull;


class AnnoncerecrutementType extends AbstractType
{
    public function buildForm (FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('posteDemande')
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
                'widget' => 'single_text', 
                'attr' => ['class' => 'form-control'], 
                'constraints' => [
                    new NotNull(),
                    new GreaterThan('today'),
                ],
                ])

                
            // ...
        ;
    }

 
   

    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annoncerecrutement::class,
            'validation_groups' => ['Default', 'my_custom_group'],
        ]);
    }
}
