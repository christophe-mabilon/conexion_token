<?php

namespace App\Controller;

use App\Entity\Message;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api")git
 *
 */
class MessageController extends AbstractController
{
    /**
     * @Route("/message", name="index_message")
     */
    public function index(MessageRepository  $repoMessage): Response
    {   $message = $repoMessage->findAll();
        return $this->json($message,200,[],['group' => 'groupMessage']);
    }

    /**
     * @Route("/message/create",name="create_message",methods="POST")
     */
    public function create(Request $req,EntityManagerInterface $em,SerializerInterface $serializer)
    {
        $jsonRecu = $req->getContent();
        $message = $serializer->deserialize($jsonRecu,Message::class,'json');
        $em->persist($message);
        $em->flush();
        return $this->json($message,200);
    }

    /**
     * @Route("/message/delete/{id}",name="message_delete",methods="DELETE")
     */
    public function delete(Message $message,EntityManagerInterface $manager):Response
    {
        $manager->remove($message);
        $manager->flush();
        $termine =  "Message bien supprimé!";
        return $this->json($termine,200);

    }

}
