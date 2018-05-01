<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
    /**
     * @var string name
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string email
     * @Assert\Email(message = "Veuillez rentrer une adresse e-mail valide.", checkMX = true, checkHost = true)
     * @Assert\NotBlank()
     */
    private $email;

    /**
     * @var string subject
     */
    private $subject;

    /**
     * @var string message
     * @Assert\NotBlank()
     */
    private $message;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }
}
