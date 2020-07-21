<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    /**
     * @Route("/book", name="book")
     */
    public function show(int $id)
    {
        var_dump();
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }
}
