<?php

namespace App\Services;

use App\Entity\Client;
use Symfony\Contracts\EventDispatcher\Event;

class EventService extends Event{
    public const CLIENT_ADDED = 'client.added';
    public const CLIENT_UPDATED = 'client.updated';

    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getClient()
    {
        return $this->client;
    }
}