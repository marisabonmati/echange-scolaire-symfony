<?php

namespace App\Form;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AffinerRechercheType extends AbstractType
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * SearchType constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('options', ChoiceType::class, array(
                'choices' => array(
                    'Accueillir' => 'voyage',
                    'Voyager' => 'accueil',
                    'Échanger' => 'échange'
                ),
                'expanded' => true,
                'multiple' => true
            ))
            ->add('Langue', ChoiceType::class, [
                'label' => 'Sélectionnez la langue',
                'choice_loader' => new CallbackChoiceLoader(function () {
                        $languages = $this->userRepository->getLanguages();
                        $languagesAsArray = array_map(function ($l) {
                        return $l['language'];
                    },  $languages);
                        $result = [];
                    foreach ($languagesAsArray as $language) {
                        foreach ($language as $l){
                            $result[ucfirst($l)] = $l;
                        }

                    }
                    return $result;
                })
            ])
            ->add('country', ChoiceType::class, [
                'label' => 'Sélectionnez le pays',
                'choice_loader' => new CallbackChoiceLoader(function () {
                        $country = $this->userRepository->getCountry();
                        $countryAsArray = array_map(function ($l) {
                        return $l['country'];
                    },  $country);
                        $result = [];
                    foreach ($countryAsArray as $country) {
                        $result[ucfirst($country)] = $country;
                    }
                    return $result;
                })
            ])
            ->add('capacity', ChoiceType::class, array(
                'choices' => array(
                    'Moins de 30 élèves' => '<30',
                    'Entre 30 et 40 élèves' => 'entre 30 et 40',
                    'Plus de 40 élèves' => '>40'

                ),
                'expanded' => true,
                'multiple' => true
            ))
            ->add('level', ChoiceType::class, [
                'choices' => array(
                    'Lycée' => 'lycee',
                    'Collège' => 'college'
                ),
                'expanded' => true,
                'multiple' => true
            ])
            ->add('submit', SubmitType::class, ['label' => 'Valider']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
                        $resolver->setDefaults([

        ]);
    }
}
