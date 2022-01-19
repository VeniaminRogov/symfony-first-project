<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\SearchForm;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\ClientForm;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ClientsController extends AbstractController
{
    public function index(Request $request,ManagerRegistry $doctrine): Response
    {
//        $clients = $doctrine->getRepository(Client::class)->findAll();

        $form = $this->createForm(SearchForm::class);
        $form->handleRequest($request);

        $clients = $doctrine->getRepository(Client::class)->sort($form->getData());

        dump($clients);

        if(!$clients){
            throw $this->createNotFoundException(
                'No found clients'
            );
        }
        return $this->render('clients/index.html.twig', [
            'clients_arr' => $clients,
        ]);
    }


    public function createAndUpdate(Request $request, ManagerRegistry $doctrine, ?int $id = null): Response{
        $client = null;

        if ($id) {
            $client = $doctrine->getRepository(Client::class)->find($id);
            if(!$client){
                throw new NotFoundHttpException('Not found');
            }
        }

        $form = $this->createForm(ClientForm::class, $client);


        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){
            $client = $form->getData();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($client);
            $entityManager->flush();
            $this->addFlash(
                'primary',
                $id ? 'Your changes were saved!' :
                'Your client is added!'
            );
            return $this->redirectToRoute('clients_form_edit', ['id' => $client->getId()]);
        }

        return $this->renderForm('clients/form.html.twig',[
            'form' => $form,
            'title' => !$id ? 'Create' : 'Edit'
        ]);
    }

    public function delete(int $id, ManagerRegistry $doctrine) : Response{
        $client = $doctrine->getRepository(Client::class)->find($id);
        $entityManager = $doctrine->getManager();
        $entityManager->remove($client);
        $entityManager->flush();

        $this->addFlash(
            'danger',
            'Delete client ---'.$id
        );

        return $this->redirectToRoute('clients_list');
    }

}
