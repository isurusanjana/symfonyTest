<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
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
        if($request->getSession()){
            $session = $request->getSession();
        } else {
            $session = new Session();
            $session->start();
        }
        
        $session->set('childBookCount', 0);
        $session->set('childBookTotal', 0);
        $session->set('totalBookCount', 0);
        $session->set('subTotal', 0);
        $session->set('discountAmount', 0);
        $session->set('total', 0);
        $session->set('bookSelected');

        $em = $this->entityManager;
        $repository = $em->getRepository(Category::class);

        $categories = $repository->findBy(['status' => 1]);
        $showBooks = false;
        $books = null;
        $selectedCategory = null;
        if ( $request->getMethod() === 'POST' ) {   
            $category = $request->request->get('category');
            $selectedCategory = $category;
            $bookRepository = $em->getRepository(Book::class);
            $books = $bookRepository->findBy(['category_id' => $category]);
            if(!empty($books)) {
                $showBooks = true;
            }
        }

        return $this->render('home/index.html.twig', [
            'categories' => $categories,
            'selected_category' => $selectedCategory,
            'show_books' => $showBooks,
            'books' => $books
        ]);
    }

}
