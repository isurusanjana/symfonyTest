<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Book;

class BookController extends AbstractController
{
    /**
     * @Route("/book", name="book")
     */
    public function show(int $cat_id)
    {
        $em = $this->entityManager;
        $repository = $em->getRepository(Book::class);

        $book = $repository->findBy(['' => ],['status' => 1]);
        
        return $this->render('book/index.html.twig', [
            'book' => $book,
        ]);
    }
}
