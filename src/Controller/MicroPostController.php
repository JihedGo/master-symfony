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
            'posts' => $repo->findBy([], ['time' => 'DESC'])
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
    /**
     * @Route("/edit/{id}", name="micro_post_edit")
     */
    public function edit(MicroPost $post, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form      = $this->createForm(MicroPostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('micro_post_index');
        }
        return $this->render('micro-post/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="micro_post_delete")
     */
    public function delete(MicroPost $post, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($post);
        $entityManager->flush();
        $this->addFlash('notice', 'Micro post was deleted');
        return $this->redirectToRoute('micro_post_index');
    }

    /**
     * @Route("/{id}", name="micro_post_post")
     */
    public function post(Request $request, MicroPost $post): Response
    {
        return $this->render('micro-post/post.html.twig', [
            'post' => $post
        ]);
    }
}