<?php

namespace App\Form;

use App\Entity\Equipe;
use App\Entity\Ouvrier;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class OuvrierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cinouvrier')
            ->add('nomouvrier')
            ->add('prenomouvrier')
            ->add('datenaissance', DateType::class, [
                'widget' => 'single_text', 
                'attr' => ['class' => 'form-control'], 
                'constraints' => [
                    new NotNull(),
                    new GreaterThan('today'),
                ],
                ])
            ->add('genreouv', ChoiceType::class, [
                'choices' => [
                    'Homme' => 'homme',
                    'Femme' => 'femme',
                ],
                'expanded' => true, // This makes it render as radio buttons
                'label' => 'Genre',
            ])
            ->add('dateembauche', DateType::class, [
                'widget' => 'single_text', 
                'attr' => ['class' => 'form-control'], 
                'constraints' => [
                    new NotNull(),
                    new GreaterThan('today'),
                ],
                ])
            ->add('email')
            ->add('adresse')
            ->add('phone')
            ->add('poste', ChoiceType::class, [
                'choices' => [
                    'Ouvrier' => 'ouvrier',
                    'chauffeur' => 'chauffeur',
                    // Add more options as needed
                ],
                'label' => 'Poste',
            ])            
            ->add('salaire')

            ->add('equipe', EntityType::class, [
                'class' => Equipe::class,
                'choice_label' => 'getNomEquipe', // Change this to the property you want to display in the dropdown
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('photo', FileType::class, [
                'label' => 'User Image (JPG, JPEG, PNG,)',
                'mapped' => false,
                'required' => false,
                'attr' => ['accept' => '.jpg,.jpeg,.png'],
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image ',
                    ]),
                ],
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ouvrier::class,
        ]);
    }
}
