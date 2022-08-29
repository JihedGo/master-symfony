<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

/**
 * @Route("/blog")
 */
class BlogController extends AbstractController
{

    private $session;
    private $router;
    public function __construct(SessionInterface $session, RouterInterface $router)
    {
        $this->session = $session;
        $this->router  = $router;
    }
    /**
     * @Route("/", name="blog_index")
     * @return Response
     */
    public function index(Request $request): Response
    {

        return $this->render('blog/index.html.twig', [
            'posts' => $this->session->get('posts')
        ]);
    }

    /**
     * 
     * @Route("/add", name="blog_add")
     * @return Response
     */
    public function add()
    {
        $posts = $this->session->get('posts');

        $posts[uniqid()] = [
            'title' => "Random Title " . rand(1, 5),
            "content" => "a random content " . rand(1, 2)
        ];
        $this->session->set('posts', $posts);
        return new RedirectResponse($this->router->generate('blog_index'));
        //return $this->redirectToRoute('blog_show', ['id' => $post]);
    }

    /**
     * 
     * @Route("/show/{id}", name="blog_show")
     * @return Response
     */
    public function show($id)
    {
        $posts = $this->session->get('posts');
        if (!$posts || !$posts[$id]) {
            throw new NotFoundHttpException("Post not found");
        }
        return $this->render('blog/post.html.twig', ['post' => $posts[$id], 'id' => $id]);
    }
}