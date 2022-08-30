<?php

namespace App\Entity;

use App\Repository\MicroPostRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MicroPostRepository::class)
 */
class MicroPost
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=280)
     */
    private $text;

    /**
     * @ORM\Column(type="datetime")
     */
    private $time;

    public function getId(): ?int
    {
        return $this->id;
    }
}