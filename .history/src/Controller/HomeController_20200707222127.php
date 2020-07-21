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
        c

        return $this->render('home/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    public function getBooks(Request $request) {
        $em = $this->entityManager;
        $repository = $em->getRepository(Book::class);
        $books = $repository->findBy(['category_id' => $catId]);
    }
}
