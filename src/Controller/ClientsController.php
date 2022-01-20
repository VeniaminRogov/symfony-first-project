<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\SearchForm;
use App\Object\ObjectSearchForm;
use App\Services\ClientModel;
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
        $searchObject = new ObjectSearchForm();
        $form = $this->createForm(SearchForm::class, $searchObject);

        $form->handleRequest($request);

        $clients = $doctrine->getRepository(Client::class)->sort($searchObject);

        return $this->render('clients/index.html.twig', [
            'clients_arr' => $clients,
            'searchForm' => $form->createView()
        ]);
    }


    public function createAndUpdate(Request $request, ManagerRegistry $doctrine, ?int $id = null, ClientModel $model): Response{
        $client = null;
        $id ? $bool = true : $bool = false;

        if($model->checkClient($id)){
            throw new NotFoundHttpException();
        }

        $form = $this->createForm(ClientForm::class, $client);

        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){
            $client = $form->getData();

            $entityManager = $doctrine->getManager();
            $model->isHasDate($client);

            $entityManager->persist($client);
            $entityManager->flush();

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
