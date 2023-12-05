<?php

namespace App\Form;

use App\Entity\Annonceinvestissement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
class AnnonceinvestissementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('montant')
            ->add('datepublication', DateType::class, [
                'widget' => 'single_text',
                'constraints' => [
                    new NotNull(),
                    new GreaterThan('today'),
                ],
                ])
            ->add('localisation',ChoiceType::class,['choices'=>['Ariana'=>'Ariana','Béja'=>'Béja','Ben Arous'=>'Ben Arous','Bizerte'=>'Bizerte','Gabès'=>'Gabès','Gafsa'=>'Gafsa','Jendouba'=>'Jendouba','Kairouan'=>'Kairouan','Kasserine'=>'Kasserine','Kébili'=>'Kébili','Le Kef'=>'Le Kef','Mahdia'=>'Mahdia','La Manouba'=>'La Manouba','Médenine'=>'Médenine','Monastir'=>'Monastir','Nabeul'=>'Nabeul','Sfax'=>'Sfax','Sidi Bouzid'=>'Sidi Bouzid','Siliana'=>'Siliana','Sousse'=>'Sousse','Tataouine'=>'Tataouine','Tozeur'=>'Tozeur','Tunis'=>'Tunis','Zaghouan'=>'Zaghouan']])
            ->add('description')
            ->add('photo', FileType::class, [
                'label' => 'Upload an image',
                'mapped' => false, // To prevent the form from trying to set this as a property on your entity
                'required' => false, // Allow the field to be optional
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonceinvestissement::class,
        ]);
    }
}
