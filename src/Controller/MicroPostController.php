<?php

namespace App\Controller;

use App\Entity\MicroPost;
use App\Entity\User;
use App\Form\MicroPostType;
use App\Repository\MicroPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

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
     * @Security("is_granted('ROLE_USER')")
     */
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {

        $user = $this->getUser();
        $microPost = new MicroPost;
        $microPost->setUser($user);
        // $microPost->setTime(new \DateTime()); replaced by LifeCycleCallback prePersist
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
    public function edit(MicroPost $post, Request $request, EntityManagerInterface $entityManager, AuthorizationCheckerInterface $checker): Response
    {
        /*if (!$checker->isGranted('edit', $post)) {
            throw new UnauthorizedHttpException();
        }*/

        $this->denyAccessUnlessGranted('edit', $post);
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
        $this->denyAccessUnlessGranted('delete', $post);
        $entityManager->remove($post);
        $entityManager->flush();
        $this->addFlash('notice', 'Micro post was deleted');
        return $this->redirectToRoute('micro_post_index');
    }

    /**
     * @Route("/user/{username}", name="micro_post_user")
     */
    public function userPosts(User $userWithPosts, MicroPostRepository $repo)
    {
        //return $this->render('micro-post/index.html.twig', ['posts' => $repo->findBy(['user' => $userWithPosts], ['time' => 'DESC'])]);
        return $this->render('micro-post/index.html.twig', ['posts' => $userWithPosts->getPosts()]);
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