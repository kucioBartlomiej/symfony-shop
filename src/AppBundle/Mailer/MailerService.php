<?php

namespace AppBundle\Mailer;

use AppBundle\Mailer\Message\Message;

class MailerService
{

    private $mailer;

    private $templating;

    /**
     * @var string
     */
    private $from;

    public function __construct($from, \Swift_Mailer $mailer, \Twig_Environment $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->from = $from;
    }

    public function sendEmailMessage(Message $message)
    {
        $mail = (new \Swift_Message())
            ->setSubject($message->getSubject())
            ->setFrom($this->from)
            ->setTo($message->getToEmail())
            ->setBody(
                $this->templating->render('Email/'.$message->getTemplate(), $message->getTemplateData()),
                'text/html'
            );

        $this->mailer->send($mail);
    }

}