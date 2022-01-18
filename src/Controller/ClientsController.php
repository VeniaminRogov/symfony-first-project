<?php

namespace App\Controller;

use App\Entity\Client;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\ClientForm;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ClientsController extends AbstractController
{
    public function index(ManagerRegistry $doctrine): Response
    {
        $clients = $doctrine->getRepository(Client::class)->findAll();
        if(!$clients){
            throw $this->createNotFoundException(
                'No found clients'
            );
        }
        return $this->render('clients/index.html.twig', [
            'title' => 'Clients list',
            'clients_arr' => $clients
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

//        dump($request);die;

        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){
            $client = $form->getData();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($client);
            $entityManager->flush();
            $this->addFlash(
                'notice',
                'Your changes were saved!'
            );
            return $this->redirectToRoute('clients_form_edit', ['id' => $client->getId()]);
        }

        return $this->renderForm('clients/form.html.twig',[
            'form' => $form
        ]);
    }

    public function delete(int $id, ManagerRegistry $doctrine) : Response{
        $client = $doctrine->getRepository(Client::class)->find($id);
        $entityManager = $doctrine->getManager();
        $entityManager->remove($client);
        $entityManager->flush();

        $this->addFlash(
            'notice',
            'Delete client ---'.$id
        );

        return $this->redirectToRoute('clients_list');
    }

}
