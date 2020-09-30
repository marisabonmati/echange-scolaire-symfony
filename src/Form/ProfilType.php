<?php

namespace App\Form;

use App\Entity\Tag;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $options = [
            'Echange' => 'Echange',
            'Hôte' => 'Hote',
            'Voyage' => 'Voyage',
        ];
        $languages = [
            'Français' => 'Francais',
            'Anglais' => 'Anglais',
            'Espagnol' => 'Espagnol',
        ];
        $level = [
            'Lycée' => 'Lycee',
            'Collège' => 'College',
        ];

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
            ->add('lastName', TextType::class, ['label' => 'Nom : ', 'required' => true])
            ->add('firstname', TextType::class, ['label' => 'Prénom : '])
            ->add('adress', TextType::class, ['label' => 'Adresse : '])
            ->add('cp', IntegerType::class, ['label' => 'Code postal : '])
            ->add('city', TextType::class, ['label' => 'Ville : '])
            ->add('country', TextType::class, ['label' => 'Pays : '])
            ->add('photoFile', FileType::class, ['label' => true, 'mapped' => false])
            ->add('descriptionProfil', TextareaType::class, ['label' => 'Description profil : '])
            ->add('descriptionSecondary', TextareaType::class, ['label' => 'Description : '])
            ->add('phone', TextType::class, ['label' => 'Phone : '])
            ->add('options', ChoiceType::class, [
                'required' => true,
                'choices' => $options,
                'placeholder' => 'Choisissez une option',
                'empty_data' => null,
            ])
            ->add('disponibilityDateStart', DateType::class, ['label' => 'Date de début : '])
            ->add('disponibilityDateEnd', DateType::class, ['label' => 'Date de fin : '])
            ->add('capacity', IntegerType::class, ['label' => 'Capacité d\'accueil : '])
            ->add('language', ChoiceType::class, [
                'required' => true,
                'choices' => $languages,
                'multiple' => true,
                'expanded' => true,
                'placeholder' => 'Choisissez une langue',
                'empty_data' => null,])
            ->add('level', ChoiceType::class, [
                'choices' => $level,
                'multiple' => true,
                'expanded' => true,
                'placeholder' => 'Choisissez votre niveau',
                'empty_data' => null,])
            ->add('tags', Select2EntityType::class, [
                'multiple' => true,
                'remote_route' => 'api_tag',
                'class' => Tag::class,
                'primary_key' => 'id',
                'text_property' => 'name',
                'minimum_input_length' => 2,
                'page_limit' => 10,
                'allow_clear' => true,
                'delay' => 250,
                'cache' => false,
                'cache_timeout' => 60000, // if 'cache' is true
                'language' => 'fr',
                'placeholder' => 'Sélectionnez un tag',
                'allow_add' => [
                    'enabled' => true,
                    'new_tag_text' => ' (Nouveau)',
                    'new_tag_prefix' => '__',
                    'tag_separators' => '[",", " "]'],
                // 'object_manager' => $objectManager, // inject a custom object / entity manager
            ])
            ->add('submit', SubmitType::class, ['label' => 'Sauvegarder les informations'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'required' => false,
            'data_class' => User::class,
        ]);
    }
}
