<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginType;
use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('index.html.twig');
    }
    
    #[Route('/login/', name: 'login')]
    public function login(Request $request): Response
    {
        $userForm = new User();    
        $form = $this->createForm(LoginType::class, $userForm);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $userForm = $form->getData();
            var_dump($userForm->getEmail());exit();
        }

        return $this->render('login.html.twig',[
            'form' => $form->createView()
        ]);
    }

    #[Route('/register', name: 'register')]
    public function register(Request $request): Response
    {
        $userForm = new User();
        $form = $this->createForm(RegisterType::class, $userForm);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $userForm = $form->getData();
            dd($userForm->getRoles());
        }

        return $this->render('register.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
