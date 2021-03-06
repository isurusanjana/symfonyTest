<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Book;

class BookController extends AbstractController
{
    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/book", name="book")
     */
    public function show(int $id)
    {
        $em = $this->entityManager;
        $repository = $em->getRepository(Book::class);

        $book = $repository->find(['id' => $id]);
  
        return $this->render('book/index.html.twig', [
            'book' => $book,
        ]);
    }

    /**
     * @Route("/add_to_cart", name="add_to_cart")
     */
    public function addToCart(int $id) {
        $em = $this->entityManager;
        $repository = $em->getRepository(Book::class);
        $book = $repository->find(['id' => $id]);
        $session = new Session();
        $session->start();
        $session->set('childBookCount', 0);
        $session->set('childBookTotal', 0);
        $session->set('totalBookCount', 0);
        $session->set('subTotal', 0);
        $session->set('discountAmount', 0);
        $session->set('total', 0);
        $this->addFlash('success', 'Article Created! Knowledge is power!');

        return $this->render('book/index.html.twig', [
            'book' => $book,
        ]);
    }

}
