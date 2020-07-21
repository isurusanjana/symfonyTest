<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
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
    public function addToCart(Request $request, int $id) {
        $em = $this->entityManager;
        $repository = $em->getRepository(Book::class);
        $book = $repository->find(['id' => $id]);
        $session = $request->getSession();

        $childBookCount = $session->get('childBookCount');
        $childBookTotal = $session->get('childBookTotal');
        $totalBookCount = $session->get('totalBookCount');
        $subTotal = $session->get('subTotal');
        $discountAmount = $session->get('discountAmount');
        $bookSelected = $session->get('bookSelected');
        if($book->getCategoryId() == 1) {
            $session->set('childBookCount', $childBookCount++);
        }
        $newBook = [$book->getId(), $book->getName(), $book->getPrice(), $book->getcover_image()];
        // array_push($bookSelected, $newBook);
        $bookSelected[$book->getId()] = $newBook;
        $total = $session->get('total');
        var_dump('Total',$session->get('childBookCount'));
        $this->addFlash('success', 'Article Created! Knowledge is power!');

        return $this->render('book/index.html.twig', [
            'book' => $book,
        ]);
    }

}
