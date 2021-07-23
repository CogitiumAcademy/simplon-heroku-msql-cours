<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{

    /**
     * @Route("/", name="app_home")
     */
    public function index(PostRepository $pr): Response
    {
        $posts = $pr->findAll();
        return $this->render('post/index.html.twig', [
            'controller_name' => 'TestController/index',
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/post/add", name="post_add")
     */
    public function addPost(Request $request): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute('app_home');
        }

        return $this->render('post/add.html.twig', [
            'controller_name' => 'TestController/add',
            'form' => $form->createView(),
        ]);
    }
}
