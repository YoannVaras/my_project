<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use Symfony\Component\HttpFoundation\Response;


class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="article")
     */
    public function index()
    {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to the action: index(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();
        $article = new Article();
        $article->setLibelle('pomme');
        $article1 = new Article();
        $article1->setLibelle('banane');
        // tell Doctrine you want to (eventually) save the article (no queries yet)
        $entityManager->persist($article);
        $entityManager->persist($article1);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        return $this->render('article/index.html.twig', [ 'controller_name' => 'ArticleController', 'article' => $article,
        ] );
    }

        /**
    * @Route("/article/{id}", name="article_detail")
    */
    public function getArticle($id)
    {
        $articles = [new Article(0, 'pommes'), new Article(1, 'poires'), new Article(2, 'pêches')];
        try 
        { 
            $article = $articles[$id]; 
            return $this->render('article/detail.html.twig', ['controller_name' => 'ArticleController', 'article' => $article, ]); 
        } 
        catch (\ErrorException $e) 
        { 
            return $this->render('article/index.html.twig', ['controller_name' => 'ArticleController', 'error' => $e->getMessage(), ]);
        }
    }

        /**
     * @Route("/produit/{id}", name="produits")
     */
    public function showOne($id)
    {
        $repository = $this->getDoctrine()->getRepository(Article::class)->find($id);
        // $products = $repository->findAll();
        if (!$repository) 
        {
            throw $this->createNotFoundException
            (
                'Produit introuvable :'.$id
            );
        }
        return new Response ('Nos produits : '.$repository->getLibelle());  
    }

        /**
     * @Route("/produits")
     */
    public function ShowAll()
    {
        $produits =$this->getDoctrine()->getRepository(Article::class)->findAll();
           var_dump($produits); 
           foreach($produits as $produit)
            {
                return new Response ('Nos produits : '.$produit->getLibelle());
                
            }
    }
}