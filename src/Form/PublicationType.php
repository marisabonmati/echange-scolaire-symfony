<?php

namespace App\Form;

use App\Entity\Publication;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PublicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $titre =
            ['Echange' => 'Echange',
            'Hôte' => 'Hote',
            'Voyage' => 'Voyage', ];
        $builder
            ->add('title', ChoiceType::class, ['choices' => $titre, 'placeholder' => 'Choisissez le type d\'échange : ', 'required' => true])
            ->add('pictureFile', FileType::class, ['mapped' => false])
            ->add('descriptionPost', TextareaType::class, ['label' => 'Description de votre échange'])
            ->add('submit', SubmitType::class, ['label' => 'Sauvegarder votre publication'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Publication::class,
        ]);
    }
}
