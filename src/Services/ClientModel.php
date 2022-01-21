<?php

namespace App\Services;

use App\Entity\Client;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;

class ClientModel{

    private $flash;
    private $doctrine;
    private $router;

    public function __construct(RequestStack $requestStack, ManagerRegistry $doctrine, RouterInterface $router)
    {
        $this->flash = $requestStack->getSession()->getFlashBag();
        $this->doctrine = $doctrine->getManager();
        $this->router = $router;
    }
    
    public function checkClient(?int $id = null)
    {
        if(!$id){
            return $id;
        }
        return $this->doctrine->getRepository(Client::class)->find($id);
    }

    public function createAndUpdateClient(Client $client, $bool): Client
    {
        if(!$client->getCreatedAt()){
            $this->createClient($client);
            $this->updatedClient($client);
        }
        $this->updatedClient($client);
        $this->flashClient($bool);

        $this->doctrine->persist($client);

        $this->doctrine->flush();

        return $client;
    }

    public function createClient(Client $client){
        $client->setCreatedAt(new \DateTime());
    }

    public function updatedClient(Client $client){
        $client->setUpdatedAt(new \DateTime());
    }

    public function deleteClient(int $id): bool
    {
        $client = $this->checkClient($id);

        $entityManager = $this->doctrine;
        $entityManager->remove($client);

        $entityManager->flush();

        return true;
    }

    private function flashClient($bool){
        $this->flash->add(
            'primary',
            $bool ? 'Your changes were saved!' :
                'Your client is added!'
        );
    }
}
