<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Coupon;

class CartController extends AbstractController
{
    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/cart", name="cart")
     */
    public function index(Request $request)
    {
        $session = $request->getSession();

        $subTotal = $session->get('subTotal');
        $total = $session->get('total');
        $bookSelected = $session->get('bookSelected');

        return $this->render('cart/index.html.twig', [
            'bookSelected' => $bookSelected,
            'subTotal' => $subTotal,
            'total' => $total,
            'bookSelected' => $bookSelected,
            'itemCount' => count($bookSelected),
            'discount' => ((int)$subTotal - (int)$total)
        ]);
    }

    public function removeFromCart(Request $request, int $id) {
        $session = $request->getSession();
        $bookSelected = $session->get('bookSelected');
        if ($bookSelected  != null && array_key_exists($id,$bookSelected)){
            unset($bookSelected[$id]);
            $session->set('bookSelected', $bookSelected);
        }

        return $this->redirectToRoute('cart');
    }

    public function addCoupon(Request $request) {
        if ( $request->getMethod() === 'POST' ) {   
            $em = $this->entityManager;
            $code = $request->request->get('coupon');
            $repository = $em->getRepository(Coupon::class);
            $coupon = $repository->find(['code' => $code]);
        }
    }
}
