<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailController extends AbstractController {
    public function sendEmail(MailerInterface $mailer){
        $email = (new Email())
            ->from('user1@mail.ru')
            ->to('rogov.veniamin@gmail.com')
            ->text('test')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $mailer->send($email);
    }
}