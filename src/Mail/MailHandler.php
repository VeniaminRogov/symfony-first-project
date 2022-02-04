<?php

namespace App\Mail;

use App\Repository\ClientRepository;
use App\Repository\UserRepository;
use App\Services\EventService;
use App\Services\MailService;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use function Symfony\Component\Translation\t;


#[AsMessageHandler]
class MailHandler{

    public function __construct(
        private MailService $mailer,
        private ClientRepository $clientRepository,
        private UserRepository $userRepository,
    )
    {
    }

    public function __invoke(MailNotification $mailNotification)
    {
        if(MailNotification::CLIENT_ADDED == $mailNotification->getType()) {
            $this->onCreateClient($mailNotification->getId());
        }
        elseif (MailNotification::USER_REGISTRATION == $mailNotification->getType()){
            $this->onRegistrationUser($mailNotification->getId(), $mailNotification->getVerificationUrl());
        }
    }

    public function onCreateClient($clientId){
        $client = $this->clientRepository->find($clientId);
        $email = (new TemplatedEmail())
            ->from('veniamin.r@zimalab.com')
            ->to('rogov.veniamin@gmail.com')
            ->subject('test')
            ->htmlTemplate('email/add_client_message.html.twig')
            ->context([
                'username' => $client->getFirstName()." ".$client->getLastName(),
                'client' => $client,
                'expiration_date' => new \DateTime()
            ]);
        $this->mailer->sendEmailAccrosMessanger($email);
    }

    public function onRegistrationUser($id, $verificationUrl){
        $user = $this->userRepository->find($id);
//        dd($user);
        $email = (new TemplatedEmail())
            ->from('veniamin.r@zimalab.com')
            ->to($user->getEmail())
            ->subject('Verify your email!')
            ->htmlTemplate('email/verify_email.html.twig')
            ->context([
                'username' => $user->getUserIdentifier(),
                'signed_url' => $verificationUrl
            ]);

        $this->mailer->sendEmailAccrosMessanger($email);
    }
}