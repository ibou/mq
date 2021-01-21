<?php

namespace App\Controller;

use App\Entity\Incident;
use App\Form\IncidentType;
use App\Message\MailNotification;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param MailerInterface $mailer
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $em, MailerInterface $mailer): Response
    {
        $task = new Incident();
        $task->setUser($this->getUser())
            ->setCreatedAt(new \DateTime('now'));
        
        $form = $this->createForm(IncidentType::class, $task);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Incident $task */
            $task = $form->getData();
            $em->persist($task);
            $em->flush();
            
            $this->dispatchMessage(
                new MailNotification($task->getDescription(), $task->getId(), $task->getUser()->getEmail())
            );
            
            return $this->redirectToRoute('home');
        }
        
        return $this->render(
            'home/index.html.twig',
            [
                'form' => $form->createView(),
                'controller_name' => 'HomeController',
            ]
        );
    }
    
    
}
