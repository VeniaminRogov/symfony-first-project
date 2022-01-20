<?php

namespace App\Services;

use App\Entity\Client;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ClientModel{

    private $flash;
    private $doctrine;

    public function __construct(RequestStack $requestStack, ManagerRegistry $doctrine)
    {
        $this->flash = $requestStack->getSession()->getFlashBag();
        $this->doctrine = $doctrine->getManager();
    }
    
    public function checkClient(?int $id): bool
    {
            $client = $this->doctrine->getRepository(Client::class)->find($id);
            if(!$client){
                return false;
            }
            return true;
    }

    public function isHasDate(Client $client){
        if(!$client->getCreatedAt()){
            $this->createClient($client);
            $this->updatedClient($client);
        }
        $this->updatedClient($client);
    }

    public function createClient(Client $client){
        $client->setCreatedAt(new \DateTime());
    }

    public function updatedClient(Client $client){
        $client->setUpdatedAt(new \DateTime());
    }

    private function flashClient($bool){
        $this->flash->add(
            'primary',
            $bool ? 'Your changes were saved!' :
                'Your client is added!'
        );
    }
}
