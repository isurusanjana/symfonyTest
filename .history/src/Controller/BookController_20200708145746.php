<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
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
        var_dump($book->name);
        var_dump($book->cover_image);
        // return $this->render('book/index.html.twig', [
        //     'book' => $book,
        // ]);
    }
}
