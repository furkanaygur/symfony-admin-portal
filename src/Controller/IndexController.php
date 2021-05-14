<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginType;
use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class IndexController extends AbstractController
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/error", name="error")
     */
    public function error(): Response
    {
        return $this->render('error.html.twig');
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        $user = new User();
        $form = $this->createForm(LoginType::class, $user);
        $form->handleRequest($request);
        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render('login.html.twig',[
            'form' => $form->createView(),
            'error' => $error,
        ]);
    }

    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();

            $plainPassword = $user->getPassword();
            $encodedPassword = $this->encoder->encodePassword($user, $plainPassword);
            $user->setPassword($encodedPassword);
            $roles = $user->getRoles();
            $user->setRoles($roles);

            $entityManager->persist($user);
            $entityManager->flush();

            $authenticationUtils->getLastAuthenticationError();
            $authenticationUtils->getLastUsername();

            return $this->redirectToRoute('index');
        }

        return $this->render('register.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
