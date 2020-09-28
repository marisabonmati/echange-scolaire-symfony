<?php

namespace App\Form;

use App\Entity\User;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $datestart = 'disponibilityDateStart';
        $builder
            ->add('email', EmailType::class, ['label' => 'E-mail'])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Renseignez votre mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins 6 caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('lastName', TextType::class, ['label' => 'Nom : '])
            ->add('firstname', TextType::class, ['label' => 'Prénom : '])
            ->add('adress', TextType::class, ['label' => 'Adresse : '])
            ->add('cp', IntegerType::class, ['label' => 'Code postal : '])
            ->add('city', TextType::class, ['label' => 'Ville : '])
            ->add('country', TextType::class, ['label' => 'Pays : '])
            ->add('photo', FileType::class, ['label' => 'Photo : '])
            ->add('descriptionProfil', TextareaType::class, ['label' => 'Description profil : '])
            ->add('descriptionSecondary', TextareaType::class, ['label' => 'Description : '])
            ->add('phone', TextType::class, ['label' => 'Phone : '])
            ->add('options', ChoiceType::class, [
                'required' => true,
                'choices' => ['Échange', 'Voyages', 'Hôte'],
                'placeholder' => 'Choisissez une option',
                'empty_data' => null,
            ])
            ->add('disponibilityDateStart', DateType::class, ['label' => 'Date de début : '])
            ->add('disponibilityDateEnd', DateType::class, ['label' => 'Date de fin : ', 'years' => range($datestart, 2022)])
            ->add('capacity', IntegerType::class, ['label' => 'Capacité d\'accueil : '])
            ->add('language', ChoiceType::class, [
                'required' => true,
                'choices' => ['Anglais', 'Français', 'Espagnol'],
                'placeholder' => 'Choisissez une langue',
                'empty_data' => null,])
            ->add('level', CheckboxType::class, [
                'mapped' => false,
                'choices' => ['Lycée', 'Collège'],
                'placeholder' => 'Choisissez une langue',
                'empty_data' => null,])
            ->add('entite', ChoiceType::class, [
                'required' => true,
                'choices' => ['Établissement', 'Enseignant'],
                'placeholder' => 'Choisissez une entité',
                'empty_data' => null,])
            ->add('tags', CollectionType::class, ['entry-type' => TextType::class, 'allow_add' => true, 'allow_delete' => true])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
