<?php

namespace App\Controller;

use App\Entity\MicroPost;
use App\Form\MicroPostType;
use App\Repository\MicroPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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


    /**
     * @Route("/add", name="micro_post_add")
     */
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $microPost = new MicroPost;
        $microPost->setTime(new \DateTime());
        $form      = $this->createForm(MicroPostType::class, $microPost);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($microPost);
            $entityManager->flush();
            return $this->redirectToRoute('micro_post_index');
        }
        return $this->render('micro-post/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}