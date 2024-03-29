<?php

namespace App\Form;

use App\Entity\Culture;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class CultureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle')
            ->add('dateplantation', null, [
                'widget' => 'single_text',
                'data' => $options['is_edit'] ? $options['data']->getDateplantation() : new \DateTime(),
            ])
            ->add('daterecolte', null, [
                'widget' => 'single_text',
                'data' => $options['is_edit'] ? $options['data']->getDaterecolte() : new \DateTime(),
            ])
            // ->add('categorytype')
            ->add('revenuescultures')
            ->add('coutsplantations')
            // ->add('user')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'type',
                'label' => 'Catégorie',
                'placeholder' => 'Sélectionner une catégorie',
                'required' => true,
            ])
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Culture::class,
            'is_edit' => false,
        ]);
    }
}
