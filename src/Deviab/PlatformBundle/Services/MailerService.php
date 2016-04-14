<?php

namespace Deviab\PlatformBundle\Services;

use FOS\UserBundle\Mailer\MailerInterface;
use FOS\UserBundle\Model\UserInterface;

/**
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
class MailerService
{
    protected $mailer;

    public function __construct($mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmailMessage($fromName, $fromEmail, $toName, $toEmail, $subject, $body)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($fromEmail, $fromName)
            ->setTo($toEmail, $toName)
            ->setBody($body);

        $this->mailer->send($message);
    }
}
