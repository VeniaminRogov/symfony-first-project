<?php

namespace App\Services;

use App\Entity\Client;
use App\Entity\User;
use App\Mail\MailNotification;
use App\Subscribers\ClientSubscriber;
use Doctrine\Persistence\ManagerRegistry;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

class ClientModel{

    private $flash;
    private $doctrine;
    private $router;
    private $user;
    private $session;
    private $slugger;
    private $targetDirectory;
    private $mailer;

    public function __construct(
        RequestStack $requestStack,
        ManagerRegistry $doctrine,
        RouterInterface $router,
        Security $security,
        $targetDirectory,
        SluggerInterface $slugger,
        MailService $email,
        private EventDispatcherInterface $dispatcher,
        private MessageBusInterface $bus
    )
    {
        $this->session = $requestStack->getSession();
        $this->doctrine = $doctrine->getManager();
        $this->router = $router;
        $this->user = $security->getUser();
        $this->slugger = $slugger;
        $this->targetDirectory = $targetDirectory;
        $this->mailer = $email;
    }
    
    public function checkClient(?int $id = null)
    {
        if(!$id){
            return $id;
        }
        return $this->doctrine->getRepository(Client::class)->find($id);
    }

    public function isUserClient(Client $client): bool
    {
        if($this->user === $client->getUser()){
            return true;
        }
        return false;
    }

    public function createAndUpdateClient(Client $client, $bool,$avatar): Client
    {
        if(!$client->getCreatedAt()){
            $this->createClient($client);
        }
        $this->updateClient($client);

        $event = new EventService($client);

        $client->setImg($this->uploadAvatar($client, $avatar));

        $this->doctrine->persist($client);

        $this->doctrine->flush();

        if ($bool){
            $this->dispatcher->dispatch($event, EventService::CLIENT_UPDATED);
        } else{
            $this->dispatcher->dispatch($event, EventService::CLIENT_ADDED);
            $this->bus->dispatch(new MailNotification($client->getId(), MailNotification::CLIENT_ADDED));
        }


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

    public function getTargetDirectory(){
        return $this->targetDirectory;
    }

    public function uploadAvatar(Client $client, ?UploadedFile $avatar = null){

        if($avatar == null){
            return $client->getImg();
        }

        try {
            unlink($this->getTargetDirectory().''.$client->getImg());

        } catch (\Exception $exception){}


        $originalFileName = pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFileName = $this->slugger->slug($originalFileName);
        $fileName = $safeFileName.'-'.uniqid().'.'.$avatar->guessExtension();

        try {
            $avatar->move($this->getTargetDirectory(), $fileName);
        } catch (FileException $e){

        }

        return $fileName;
    }

    public function deleteClient(Client $client): bool
    {
        $entityManager = $this->doctrine;
        $entityManager->remove($client);

        $entityManager->flush();

        return true;
    }

//    public function flashClient($bool){
//        $this->flash->add(
//            'primary',
//            $bool ? 'Your changes were saved!' :
//                'Your client is added!'
//        );
//    }
}
