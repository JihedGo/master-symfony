<?php

namespace App\Controller;

use App\Repository\NotificationRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Security("is_granted('ROLE_USER')")
 * @Route("/notification")
 */
class NotificationController extends AbstractController
{

    private $notificationRepository;
    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    /**
     * @Route("/unread-count",name="notification_unread")
     */
    public function unreadCount()
    {
        new JsonResponse([
            'count' => $this->notificationRepository->findUnseenByUser($this->getUser())
        ]);
    }
}