<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Serializable;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\column(type="string",length=50, unique=true)
     */
    private $username;
    /**
     * @ORM\column(type="string")
     */
    private $password;
    /**
     * @ORM\column(type="string", length=254, unique=true)
     */
    private $email;
    /**
     * @ORM\column(type="string", length=50)
     */
    private $fullName;

    public function setUsername(string $username)
    {
        $this->username = $username;
    }


    public function setPassword(string $password)
    {
        $this->password = $password;
    }


    public function setFullname(string $fullName)
    {
        $this->fullName = $fullName;
    }

    public function getFullname()
    {
        return $this->fullName;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function eraseCredentials()
    {
    }

    public function serialize()
    {
        return serialize([
            $this->id, $this->username, $this->password
        ]);
    }

    public function unserialize($serialized)
    {
        list($this->id, $this->username, $this->password) = unserialize($serialized);
    }
}