<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BlogApiController extends AbstractController
{
    /**
     * @Route("/blog/api", name="blog_api")
     */
    public function index()
    {
        return $this->render('blog_api/index.html.twig', [
            'controller_name' => 'BlogApiController',
        ]);
    }
}
