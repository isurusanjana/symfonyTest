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
    public function show(int $id)
    {
        $em = $this->entityManager;
        $repository = $em->getRepository(Book::class);

        $books = $repository->findBy(['status' => 1]);
        
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }
}
