<?php

namespace App\Controller;

use App\Form\SearchForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class FormController extends AbstractController {

    public function formRender(): Response{
        $form = $this->createForm(SearchForm::class);

        return $this->renderForm('components/searchForm.html.twig', [
           'searchForm' => $form
        ]);
    }
}