<?php

namespace App\Service;

use App\Form\RegistrationFormType;
use Symfony\Component\Form\FormFactoryInterface;

class FormService
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * FormService constructor.
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function getRegistrationForm()
    {
        return $this->formFactory->create(RegistrationFormType::class)->createView();
    }
}