<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Category;
use App\Entity\Book;

class HomeController extends AbstractController
{
    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        $em = $this->entityManager;
        $repository = $em->getRepository(Category::class);

        $test = $repository->findBy(['status' => 1]);
        var_dump($teszt);
  s

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
