<?php
/**
 * Created by PhpStorm.
 * User: alaeddine
 * Date: 07.03.19
 * Time: 17:12
 */

namespace App\Service;


class MailerService
{
    const CHANGE_PASSWORD = 'changePassword.html.twig';
    const FORGOT_PASSWORD = 'forgotPassword.html.twig';
    const REGISTER_USER = 'registrationPassword.html.twig';


    protected $twig;

    protected $mailer;

    public function __construct(\Twig_Environment $twig, \Swift_Mailer $mailer)
    {
        $this->twig = $twig;
        $this->mailer = $mailer;
    }

    public function onMailChangePasswordEvent(EmailChangePasswordEvent $event): void
    {
        $user = $event->getUser();
        $name = $event->getUser()->getName();
        $email = $event->getUser()->getEmail();
        $password = $event->getUser()->getPassword();

        $body = $this->renderTemplate($name, $password, $email);

        $message = (new \Swift_Message('Change Password Successfully!'))
            ->setFrom($email)
            ->setTo($email)
            ->setBody($body, 'text/html')
        ;

        $this->mailer->send($message);
    }

    protected function renderTemplate($name, $password, $email, $template = self::CHANGE_PASSWORD): string
    {
        return $this->twig->render(
            "emails/$template",
            [
                'name' => $name,
                'password' => $password,
                'email' => $email
            ]
        );
    }
}