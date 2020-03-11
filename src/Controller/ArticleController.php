<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use Symfony\Component\HttpFoundation\Response;


class ArticleController extends AbstractController
{
        /**
     * @Route("/produits")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Article::class)->findAll();
        return $this->render('article/index.html.twig', ['controller_name' => 'ArticlesController', 'repository' => $repository]);
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
        $repository = $this->getDoctrine()->getRepository(Article::class)->findAll();
        return $this->render('article/index.html.twig', ['controller_name' => 'ArticlesController', 'repository' => $repository]);
    }

            /**
     * @Route("/fill")
     */
    public function New()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $produit1 = new Article();
        $produit2 = new Article();
        $produit1->setLibelle('Clavier');
        $produit2->setLibelle('Souris');
        $entityManager->persist($produit1);
        $entityManager->persist($produit2);
        $entityManager->flush();
        return new Response('Produit ajouté ! Nom : ' . $produit1->getLibelle() . ' et ' . $produit2->getLibelle());
    }
}