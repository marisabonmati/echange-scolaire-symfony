<?php

namespace App\Form;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType 
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
    /*        ->add('country', ChoiceType::class, [
                'choice_loader' =>  new CallbackChoiceLoader(function() {
                    return UserRepository::getLanguages();
                })
            ])*/

            ->add('language', EntityType::class, [
                    'class' => User::class,
                    'choice_label'=> 'language'
            ])
            ->add('options', ChoiceType::class, [
                'choices'=> [
                    'Accueillir',
                    'Voyage',
                    'Echange'
                ]
            ])
            ->add('level', ChoiceType::class,[
                'choices'=> [
                    'Lycée',
                    'Collège'
                ]
            ])
            ->add('submit', SubmitType::class, ['label' => 'Rechercher'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
