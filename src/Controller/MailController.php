<?php
namespace App\Controller;

use App\Entity\Client;
use http\Env\Response;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailController extends AbstractController {

    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }


    public function sendEmail(Client $client){
        $email = (new TemplatedEmail())
            ->from('veniamin.r@zimalab.com')
            ->to('rogov.veniamin@gmail.com')
            ->subject('test')
            ->htmlTemplate('email/add_client_message.html.twig')
            ->context([
                'username' => $client->getUser()->getUserIdentifier(),
                'client' => $client->getFirstName().' '.$client->getLastName(),
                'expiration_date' => new \DateTime()
            ]);
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            dump($e->getDebug());
        }
    }
}