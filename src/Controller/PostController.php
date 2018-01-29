<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 26.01.2018
 * Time: 15:37
 */

namespace App\Controller;


use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
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
     * @Route("/posts", name="all_posts")
     */
    public function showAllPosts()
    {
        $repo = $this->getDoctrine()->getRepository(Post::class);
        $latestPosts = $repo->findBy( [], ['postedAt' => 'DESC']);

        return $this->render('post/homepage.html.twig', ['posts'=>$latestPosts]);
    }

    /**
     * @Route("/post/{id}", name="full_post", requirements={"id": "\d+"})
     */
    public function showFullPost(Post $post, Request $request, EntityManagerInterface $em)
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $comment->setPost($post);
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('full_post', ['id'=>$post->getId()] );
        }

        return $this->render('post/fullPost.html.twig', [
            'post'=>$post,
            'form' => $form->createView(),
        ]);
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

            return $this->redirectToRoute('full_post', ['id'=>$post->getId()] );
        }

        return $this->render('post/modifyPost.html.twig', ['form' => $form->createView(), 'post' => $post]);
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

            return $this->redirectToRoute('full_post', ['id'=>$post->getId()] );
        }

        return $this->render('post/newPost.html.twig', ['form' => $form->createView(),
        ]);
    }



}