<?php

namespace App\Entity;

use App\Repository\LikeNotificationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LikeNotificationRepository::class)
 */
class LikeNotification extends Notification
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MicroPost")
     */
    private $microPost;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $likeBy;

    /**
     * Get the value of microPost
     */
    public function getMicroPost()
    {
        return $this->microPost;
    }

    /**
     * Set the value of microPost
     *
     * @return  self
     */
    public function setMicroPost($microPost)
    {
        $this->microPost = $microPost;

        return $this;
    }

    /**
     * Get the value of likeBy
     */
    public function getLikeBy()
    {
        return $this->likeBy;
    }

    /**
     * Set the value of likeBy
     *
     * @return  self
     */
    public function setLikeBy($likeBy)
    {
        $this->likeBy = $likeBy;

        return $this;
    }
}