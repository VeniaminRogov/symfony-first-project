<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\User;
use App\Form\SearchForm;
use App\Object\ObjectSearchForm;
use App\Repository\ClientRepository;
use App\Services\ClientModel;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\ClientForm;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ClientsController extends AbstractController
{
    public function index(Request $request,ManagerRegistry $doctrine, PaginatorInterface $paginator): Response
    {
        $user = $this->getUser();

        $searchObject = new ObjectSearchForm();
        $form = $this->createForm(SearchForm::class, $searchObject);

        $form->handleRequest($request);

        $clients = $doctrine->getRepository(Client::class)->sort($searchObject);

        $pagination = $paginator->paginate(
          $clients,
          $searchObject->getPage(),
          10
        );


        return $this->render('clients/index.html.twig', [
            'searchForm' => $form->createView(),
            'pagination' => $pagination,
            'user' => $user
        ]);
    }


    public function createAndUpdate(Request $request, ?int $id = null, ClientModel $model): Response{
        $id ? $bool = true : $bool = false;

        $client = $model->checkClient($id);

        $form = $this->createForm(ClientForm::class, $client);

        $form->handleRequest($request);

        if($client){
            if(!$this->isGranted('edit', $client)){
//                if(!$model->isUserClient($client)){
//                }
                return $this->redirectToRoute('clients_list');
            }
        }

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

    public function lastEdit(Request $request){
        $lastId = $request->getSession()->get('lastId');

    }

    public function delete(int $id, ClientModel $model) : Response{
        $client = $model->checkClient($id);
        if($this->isGranted('delete', $client)){
            $model->deleteClient($client);

            $this->addFlash(
                'danger',
                'Delete client ---'.$id
            );
        }
        return $this->redirectToRoute('clients_list');
    }
}
