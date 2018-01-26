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
     * @Route("/post/{id}", name="full_post", requirements={})
     */
    public function showFullPost()
    {
        return $this->render('');
    }


    /**
     * @Route("/new-post", name="create_new_post")
     */
    public function post(Request $request, EntityManager $em)
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

        return $this->render('post/new_Post.html.twig', ['form' => $form->createView(),
        ]);
    }


}