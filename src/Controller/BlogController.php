<?php

namespace App\Controller;

use App\Service\Greeting;
use App\Service\VeryBadDesign;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{

    private $greeting;
    private $badDesign;
    public function __construct(Greeting $greeting, VeryBadDesign $badDesign)
    {
        $this->greeting  = $greeting;
        $this->badDesign = $badDesign;
    }
    /**
     * @Route("/blog", name="app_blog")
     */
    public function index(Request $request): Response
    {
        return $this->render('base.html.twig', [
            'message' => $this->greeting->greet($request->get("name"))
        ]);
    }
}