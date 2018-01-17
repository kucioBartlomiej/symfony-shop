<?php


namespace AppBundle\Mailer\Message;


abstract class Message
{

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $toEmail;

    /**
     * @var string
     */
    private $template;

    /**
     * @var array
     */
    private $templateData;

    public function __construct(
        string $subject,
        string $toEmail,
        string $template,
        array $templateData = array()
    ){
        $this->subject = $subject;
        $this->toEmail = $toEmail;
        $this->template = $template;
        $this->templateData = $templateData;
    }


    public function getSubject(): string
    {
        return $this->subject;
    }


    public function getToEmail(): string
    {
        return $this->toEmail;
    }


    public function getTemplate(): string
    {
        return $this->template;
    }


    public function getTemplateData(): array
    {
        return $this->templateData;
    }

}