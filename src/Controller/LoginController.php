<?php

namespace App\Controller;

use App\Form\LoginForm;
use App\Object\ObjectLoginForm;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    public function index(AuthenticationUtils $authenticationUtils, Request $request, ManagerRegistry $doctrine): Response
    {
//        $error = $authenticationUtils->getLastAuthenticationError();

//        $lastUserName = $authenticationUtils->getLastUsername();

        $loginObject = new ObjectLoginForm();
        $form = $this->createForm(LoginForm::class, $loginObject);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $login = $form->getData();
            $em = $doctrine->getManager();
            $em->persist($login);
            $em->flush();
        }

        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
//            'last_username' => $lastUserName,
//            'error' => $error,
            'login_form' => $form->createView()
        ]);
    }
}
