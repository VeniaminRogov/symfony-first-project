<?php
namespace App\Controller;



use App\Entity\Client;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController {
    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function countClient(ManagerRegistry $doctrine): Response{
//        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
//        $user = $this->getUser();

//        $userName = $user->getUsername();

        $count = $doctrine->getRepository(Client::class)->countClients();
        return $this->render('components/header.html.twig', [
            'count' => $count,
//            'user' => $userName
        ]);
    }
}