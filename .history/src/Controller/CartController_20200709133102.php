<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart")
     */
    public function index(Request $request)
    {
        $childBookCount = $session->get('childBookCount');
        $childBookTotal = $session->get('childBookTotal');
        $totalBookCount = $session->get('totalBookCount');
        $subTotal = $session->get('subTotal');
        $discountAmount = $session->get('discountAmount');
        $total = $session->get('total');
        $bookSelected = $session->get('bookSelected');

        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }
}
