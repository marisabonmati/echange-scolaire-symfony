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
                'choice_loader' =>  new CallbackChoiceLoader(function() {
                    $languages = $this->userRepository->getLanguages();
                    $languagesAsArray = array_map(function($l){
                        return $l['language'];
                    }, $languages);
                    // $languagesAsArray = ['anglais', 'français', 'suisse']
                    // => [ 'Anglais' => 'anglais', 'Français' => 'français', 'Suisse' => 'suisse']
                    $result = [];
                    foreach($languagesAsArray as $language) {
                        $result[ucfirst($language)] = $language;
                    }
                    return $result;
                })
            ])

            /*->add('language', EntityType::class, [
                    'class' => User::class,
                    'choice_label'=> 'language'
            ])*/
            ->add('Options', ChoiceType::class, [
                'choices'=> [
                    'Accueillir' => 'accueil',
                    'Voyage' => 'voyage',
                    'Echange' => 'échange'
                ]
            ])
            ->add('Entite', ChoiceType::class,[
                'choices'=> [
                    'Enseignant' => 'enseignant',
                    'Etablissement' => 'etablissement'
                ]
            ])
            ->add('submit', SubmitType::class, ['label' => 'Valider'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
