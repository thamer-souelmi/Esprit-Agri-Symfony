<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cin')
            ->add('nom', null, [
                'label' => 'Nom ',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nom du produit',
                ],
            ])
            ->add('prenom')
            ->add('mail', null, [
                'label' => 'Email',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Email',
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('mdp', RepeatedType::class, array(
                'type' => PasswordType::class,
                
                'invalid_message' => 'Les mots de passe ne correspondent pas.',
                'first_options' => array('label' => 'Mot de passe'),
                'second_options' => array('label' => 'Confirmation du mot de passe'),
            ))
            ->add('adresse')
            ->add('numtel', null, [
                'label' => 'Numéro de téléphone',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Numéro de téléphone',
                ],
            ])
            ->add('role', ChoiceType::class, [
                'choices' => [
                    
                    'Agriculteur' => 'agriculteur',
                    'Client' => 'client',
                    'Investisseur'=>'investisseur',
                    'Veterinaire'=>'veterinaire',
                    'Ouvrier'=>'ouvrier'
                ],
            ])
            ->add('image', FileType::class, [
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
            'data_class' => User::class,
        ]);
    }
}