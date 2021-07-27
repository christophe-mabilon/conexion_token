<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function register(Request $req,SerializerInterface $serializer,EntityManagerInterface $manager,UserPasswordHasherInterface $hasher): Response
    {
    $user = new User;
    $formulaire = $this->createForm(UserType::class,$user);
    $formulaire->handleRequest($req);
    if($formulaire->isSubmitted() && $formulaire->isValid()){
        $hasedPasword = $hasher->hashPassword($user,$user->getPassword());
        $user->setPassword($hasedPasword);
        $manager->persist($user);
        $manager->flush();
        return $this->redirectToRoute('login');
    }
    return $this->render('user/register.html.twig',[
        "formulaireRegister" => $formulaire->createView()

    ]);
    }

    /**
     *
     * @Route("/login",name="login")
     */
    public function login()
    {
        return $this->render('user/login.html.twig');
    }

    /**
     *
     * @Route("/logout",name="logout")
     */
    public function logout()
    {
        return $this->render('user/login.html.twig');
    }
}
