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
    public function show(Request $request, int $id)
    {
        $em = $this->entityManager;
        $repository = $em->getRepository(Book::class);

        $book = $repository->find(['id' => $id]);
        // $session = $request->getSession();
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
        $total = $session->get('total');
        $bookSelected = $session->get('bookSelected');

        if($book->getCategoryId() == 1) {
            $session->set('childBookCount', ($childBookCount == null) ? 1 : ($childBookCount+ 1));
            $session->set('childBookTotal', ($childBookTotal == null) ? $book->getPrice() : ($childBookTotal + $book->getPrice()));
        }

        $session->set('totalBookCount', ($totalBookCount == null) ? 1 : ($totalBookCount+ 1));        
        $session->set('subTotal', ($subTotal == null) ? $book->getPrice() : ($subTotal+ $book->getPrice()));
        $session->set('total', ($total == null) ? $book->getPrice() : ($session->get('total') + $book->getPrice()));

        if($session->get('childBookCount') >= 5){
            $session->set('total',  ($session->get('subTotal') * (90/100)));
        }
        
        if($session->get('totalBookCount') >= 10){
            $reduceTotalAmount = $session->get('total') * (5/100);
            $session->set('total',  ($session->get('total')- $reduceTotalAmount));
        }
        
        $selectedBookCount = 0;
        if ($session->get('bookSelected') != null && array_key_exists($book->getId(),$bookSelected)){
            $selectedBookCount = $bookSelected[$book->getId()][5] + 1;
        } else {
            $selectedBookCount = 1;
        }

        $newBook = [$book->getId(), $book->getName(),  $book->getDescription(), $book->getPrice(), $book->getcover_image(),$selectedBookCount];
        $bookSelected[$book->getId()] = $newBook;
        $session->set('bookSelected', $bookSelected);
        $session->set('discountAmount', ());

        $this->addFlash('success', 'Article Created! Knowledge is power!');

        return $this->redirectToRoute('book',['id' => $id]);
        // return $this->render('book/index.html.twig', [
        //     'book' => $book,
        // ]);
    }

}
