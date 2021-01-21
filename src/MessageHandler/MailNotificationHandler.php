<?php

namespace App\MessageHandler;

use App\Message\MailNotification;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Mime\Address;

class MailNotificationHandler implements MessageHandlerInterface
{

    private MailerInterface $mailer;
    
    /**
     * MailNotificationHandler constructor.
     * @param MailerInterface $mailer
     */
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }
    
    public function __invoke(MailNotification $message)
    {
    
        $email = (new TemplatedEmail())
            ->from(new Address($message->getFrom()))
            ->to('admin.incident@iboufact.io')
            ->subject('New Incident #' . $message->getId() . ' - ' . $message->getFrom())
            ->html("<p>".$message->getDescription()."</p>")
        ;
        sleep(5);
        $this->mailer->send($email);
    }
    
    
}