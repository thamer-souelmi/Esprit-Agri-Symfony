<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cin')
            ->add('nom')
            ->add('prenom')
            ->add('mdp', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options' => array('label' => 'Mot de passe'),
                'second_options' => array('label' => 'Confirmation du mot de passe'),
            ))
            ->add('mail')
            ->add('adresse')
            ->add('numtel')
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
            ->add('isBanned', ChoiceType::class, [
                'choices' => [
                    'Banned' => true,
                    'Not Banned' => false,
                ],
                'expanded' => true,
                'label' => 'Ban User',
                'required' => true,
            ])
            ->add('banExpiresAt', null, [
                'label' => 'Ban Duration',
                
                'attr' => ['class' => 'js-datetimepicker'],
            ])
            ->add('save',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
