<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AffinerRechercheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('country', ChoiceType::class, [
                'label' => 'Sélectionnez le pays',
                'choice_loader' =>  new CallbackChoiceLoader(function() {
                    $country = $this->userRepository->getCountry();
                    $countryAsArray = array_map(function($l){
                        return $l['country'];
                    }, $country);
                    $result = [];
                    foreach($countryAsArray as $country) {
                        $result[ucfirst($country)] = $country;
                    }
                    return $result;
                })
            ])
            ->add('options' , ButtonType::class,[
            'label' => 'Vous souhaitez',
                'choices'=> [
                                'Accueillir' => 'voyage',
                                'Voyager' => 'accueil',
                                'Echanger' => 'échange'
                            ]
            ])
            ->add('capacity' , ButtonType::class,[
                'label' => 'Vous souhaitez',
                'choices'=> [
                    'Moins de 30 élèves' => 'null',
                    'Entre 30 et 40 élèves' => 'null',
                    'Plus de 40 élèves' => 'null'
                ]
            ])
            ->add('Langue', ChoiceType::class, [
                'label' => 'Sélectionnez la langue',
                'choice_loader' =>  new CallbackChoiceLoader(function() {
                    $languages = $this->userRepository->getLanguages();
                    $languagesAsArray = array_map(function($l){
                        return $l['language'];
                    }, $languages);
                    $result = [];
                    foreach($languagesAsArray as $language) {
                        $result[ucfirst($language)] = $language;
                    }
                    return $result;
                })
            ])
            ->add('level' , CheckboxType::class,[
                'Lycée' => 'lycée',
                'Collège' => 'collège'
            ] )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
