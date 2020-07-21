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
        $session = $request->getSession();
        var_dump('Total',$session->get('childBookCount'));
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
        $session->set('total', ($total == null) ? $subTotal : ($childBookCount+ 1));
        if($childBookCount > 5){
            $reduceAmount = $session->get('subTotal') * (10/100);
            var_dump($reduceAmount);
            $session->set('total', ($childBookCount == null) ? $reduceAmount : ($reduceAmount+ 1));
        }
        
        
        $newBook = [$book->getId(), $book->getName(), $book->getPrice(), $book->getcover_image()];
        // array_push($bookSelected, $newBook);
        $bookSelected[$book->getId()] = $newBook;
        $total = $session->get('total');
        var_dump('Total',$session->get('childBookCount'));
        $this->addFlash('success', 'Article Created! Knowledge is power!');

        return $this->redirectToRoute('book',['id' => $id]);
    }

}
