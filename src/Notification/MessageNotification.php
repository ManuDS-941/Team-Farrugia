<?php

namespace App\Notification;

use Swift_Mailer;
use Swift_Message;
use App\Entity\Message;
use Twig\Environment;

class MessageNotification
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $renderer;
    
    public function __construct(\Swift_Mailer $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }

    public function notify(Message $message)
    {
        $message = (new \Swift_Message('Message : ' . $message->getMessage()))
            ->setFrom($message->getEmail())
            ->setTo('manuds941@gmail.com')
            ->setReplyTo($message->getEmail())
            ->setBody($this->renderer->render('emails/contact.html.twig', [
                'message' => $message
            ]), 'text/html');
        $this->mailer->send($message);
    }
}
