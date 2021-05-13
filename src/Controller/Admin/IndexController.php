<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/admin', name: 'admin_index')]
    public function index(): Response
    {
        $users = $this->getDoctrine()
            ->getRepository(User::class)->findAll();
        
        return $this->render('admin/index.html.twig',[
            'users' => $users
        ]);
    }
}
