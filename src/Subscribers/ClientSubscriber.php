<?php

namespace App\Subscribers;

use App\Services\EventService;
use App\Services\MailService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class ClientSubscriber implements EventSubscriberInterface
{

//    private $client;

    public function __construct(
        private RequestStack $requestStack,
        private MailService $mailer
    )
    {
    }


    public static function getSubscribedEvents()
    {
        return [
            EventService::CLIENT_ADDED => 'onClientAdded',
            EventService::CLIENT_UPDATED => 'onClientUpdated'
        ];
    }


    public function onClientAdded(EventService $event){
        $flash = $this->requestStack->getSession()->getFlashBag();
        $flash->add(
            'primary',
            'Add client'
        );
    }

    public function onClientUpdated(EventService $event){
        $client = $event->getClient();
        $flash = $this->requestStack->getSession()->getFlashBag();
        $flash->add(
            'primary',
            'Update client: '.$client->getId()
        );
    }
}