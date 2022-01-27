<?php

namespace App\Services;

use App\Entity\Client;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Security;

class ClientModel{

    private $flash;
    private $doctrine;
    private $router;
    private $user;
    private $session;

    public function __construct(RequestStack $requestStack, ManagerRegistry $doctrine, RouterInterface $router, Security $security)
    {
        $this->session = $requestStack->getSession();
        $this->flash = $requestStack->getSession()->getFlashBag();
        $this->doctrine = $doctrine->getManager();
        $this->router = $router;
        $this->user = $security->getUser();
    }
    
    public function checkClient(?int $id = null)
    {
        if(!$id){
            return $id;
        }
        return $this->doctrine->getRepository(Client::class)->find($id);
    }

    public function isUserClient(Client $client)
    {
        if($this->user === $client->getUser()){
            return true;
        }
        return false;
    }

    public function createAndUpdateClient(Client $client, $bool): Client
    {
        if(!$client->getCreatedAt()){
            $this->createClient($client);
        }
        $this->updateClient($client);
        $this->flashClient($bool);


//        dump($this->session->get('lastId'));die;

        $this->doctrine->persist($client);

        $this->doctrine->flush();

        $this->session->set('lastId',$client->getId());

        return $client;
    }

    public function createClient(Client $client){
        $client->setCreatedAt(new \DateTime());
        $client->setUser($this->user);
    }

    public function updateClient(Client $client){
        $client->setUpdatedAt(new \DateTime());
    }

    public function deleteClient(Client $client): bool
    {
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
