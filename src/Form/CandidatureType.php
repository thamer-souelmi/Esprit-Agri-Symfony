<?php

namespace App\Form;

use App\Entity\Candidature;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CandidatureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('messagemotivation')
            ->add('datecandidature')
            ->add('experienceprofessionnelle')
            ->add('formation')
            ->add('competencestechniques')
            ->add('certifforma', FileType::class,[
                'label'=> 'User Image (JPG,JPEG,PNG file)',
                'mapped'=> false,
                'required'=>false,
                'attr'=> ['accept'=>'certifforma/*'],
            ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Candidature::class,
        ]);
    }
}
