<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
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
            ->where('c.status > :price')
            ->setParameter('price', '19.99')
            ->orderBy('p.created_date', 'DESC')
            ->getQuery();

        $products = $query->getResult();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
