<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepageAction()
    {
        return $this->render(
            'BlogBundle:default:homepage.html.twig',
            [
                'post_link' => $this->get('router')->generate('post_list'),
            ]
        );
    }

}
