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
//        dump($clients);die;
        return $this->render('clients/index.html.twig', [
            'clients_arr' => $clients,
            'searchForm' => $form->createView()
        ]);
    }


    public function createAndUpdate(Request $request, ManagerRegistry $doctrine, ?int $id = null, ClientModel $model): Response{
        $id ? $bool = true : $bool = false;

        $form = $this->createForm(ClientForm::class, $model->checkClient($id));

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $client = $form->getData();

            $model->createAndUpdateClient($client, $bool);

            return $this->redirectToRoute('clients_form_edit', ['id' => $client->getId()]);
        }

        return $this->renderForm('clients/form.html.twig',[
            'form' => $form,
            'title' => !$id ? 'Create' : 'Edit'
        ]);
    }

    public function delete(int $id, ClientModel $model) : Response{
        if(!$model->deleteClient($id)){
            throw new NotFoundHttpException;
        }

        $this->addFlash(
            'danger',
            'Delete client ---'.$id
        );

        return $this->redirectToRoute('clients_list');
    }
}
