<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Post;
use BlogBundle\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/articles")
 */
class PostController extends Controller
{
    /**
     * @Route("/", name="post_list")
     */
    public function listAction(Request $request)
    {
        $manager = $this->get('doctrine')->getManager();
//        $posts = $manager->getRepository(Post::class)->findAll();
        $posts = $manager->getRepository(Post::class)->getRecent();

        return $this->render(
            'BlogBundle:post:list.html.twig',
            [
                'posts' => $posts,
            ]
        );
    }

    /**
     * @Route("/detail/{id}", name="post_show")
     */
    public function showAction(Request $request, $id)
    {
        $repository = $this->get('doctrine')->getManager()->getRepository(Post::class);
        $post = $repository->find($id);

        return $this->render(
            'BlogBundle:post:show.html.twig',
            [
                'post' => $post,
            ]
        );
    }

    /**
     * @Route("/create", name="post_create")
     */
    public function createAction(Request $request)
    {
        $post = new Post();
        $post->setTitle('Mon troisème atricle');
        $post->setContent('Voici le contenu de mon troisième article');

        $form = $this->createForm(PostType::class);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $manager = $this->get('doctrine')->getManager();
            $manager->persist($post);
            $manager->flush();

            return $this->redirectToRoute('post_list');
        }

        return $this->render(
            'BlogBundle:post:create.html.twig',
            [
                'my_form' => $form->createView(),
            ]
        );
    }
}
