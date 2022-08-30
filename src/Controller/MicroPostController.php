<?php

namespace App\Controller;

use App\Entity\MicroPost;
use App\Repository\MicroPostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/micro-post")
 */
class MicroPostController extends AbstractController
{
    /**
     * @Route("/", name="micro_post_index")
     */
    public function index(MicroPostRepository $repo): Response
    {
        return $this->render('micro-post/index.html.twig', [
            'posts' => $repo->findAll()
        ]);
    }
}