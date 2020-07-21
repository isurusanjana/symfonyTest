<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
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
    public function index(Request $request)
    {
        $em = $this->entityManager;
        $repository = $em->getRepository(Category::class);

        $categories = $repository->findBy(['status' => 1]);
        $showBooks = false;
        $books = null;
        $selectedCategory = null;
        if ( $request->getMethod() === 'POST' ) {   
            $category = $request->request->get('category');
            $bookRepository = $em->getRepository(Book::class);
            $books = $bookRepository->findBy(['category_id' => $category]);
            if(!empty($books)) {
                $showBooks = true;
            }
        }

        return $this->render('home/index.html.twig', [
            'categories' => $categories,
            'selected'
            'show_books' => $showBooks,
            'books' => $books
        ]);
    }

}
