<?php

namespace App\Form;

use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RechercheType extends AbstractType
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
            ->add('Langue', ChoiceType::class, [
                'label' => 'Sélectionnez la langue',
                'choice_loader' => new CallbackChoiceLoader(function () {
                    $languages = $this->userRepository->getLanguages();
                    $languagesAsArray = array_map(function ($l) {
                        return $l['language'];
                    }, $languages);
                    $result = [];
                    foreach ($languagesAsArray as $language) {
                        foreach ($language as $l){
                            $result[ucfirst($l)] = $l;
                        }

                    }
                return $result;
                })
            ])
            ->add('Options', ChoiceType::class, [
                'label' => 'Vous souhaitez',
                'choices' => [
                    'Accueillir' => 'voyage',
                    'Voyager' => 'accueil',
                    'Echanger' => 'echange'
                ]
            ])
            ->add('Entite', ChoiceType::class, [
                'label' => 'Vous recherchez un',
                'choices' => [
                    'Enseignant' => 'enseignant',
                    'Etablissement' => 'établissement'
                ]
            ])
            ->add('submit', SubmitType::class, ['label' => 'Valider']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
        ]);
    }
}
