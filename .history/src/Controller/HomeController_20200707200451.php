<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Category;
use App\Entity\Book;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Category::class);

        $query = $repository->createQueryBuilder('c')
            ->where('c.status = :val')
            ->setParameter('val','1')
            ->orderBy('c.created_date', 'DESC')
            ->getQuery();

        $products = $query->getResult();

        $repository = $em->getRepository(Article::class);
        $articles = $repository->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
