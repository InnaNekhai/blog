<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 26.01.2018
 * Time: 15:37
 */

namespace App\Controller;


use App\Entity\Post;
use App\Form\PostType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Post::class);
        $latestPosts = $repo->findBy( [], ['postedAt' => 'DESC'], 3);

        return $this->render('post/homepage.html.twig', ['posts'=>$latestPosts]);
    }

    /**
     * @Route("/post/{id}", name="full_post", requirements={"id": "\d+"})
     */
    public function showFullPost(Post $post)
    {
        return $this->render('post/fullPost.html.twig', ['post'=>$post]);
    }

    /**
     * @Route("/modify-post/{id}", name="modifyPost", requirements={"id": "\d+"})
     */
    public function modifyPost(Request $request, Post $post, EntityManagerInterface $em)
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em->persist($post);
            $em->flush();
            $this->addFlash('info', 'Пост опубликован');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('post/modifyPost.html.twig', ['form' => $form->createView()]);
    }


    /**
     * @Route("/new-post", name="create_new_post")
     */
    public function post(Request $request, EntityManagerInterface $em)
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($post);
            $em->flush();
            $this->addFlash('info', 'Пост опубликован');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('post/newPost.html.twig', ['form' => $form->createView(),
        ]);
    }


}