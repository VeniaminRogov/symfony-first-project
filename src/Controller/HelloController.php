<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
Use Symfony\Component\HttpFoundation\Request;
Use Symfony\Component\HttpFoundation\Response;

class HelloController extends AbstractController {

    public function hello(string $name, Request $request): Response{
        $lastName = $request->get("LastName", "Guest");
        return $this->render('Hello/hello.html.twig', [
            'namePage' => 'Hello Page',
            'lastName' => $lastName,
            'name' => $name
        ]);
    }
}