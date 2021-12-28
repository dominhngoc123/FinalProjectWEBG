<?php

namespace App\Controller;

use App\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(): Response
    {
            $books = $this->getDoctrine()->getRepository(Book::class)->findAll();
            return $this->render("home/index.html.twig",
            [
                'books' => $books
            ]);
    }
    /**
     * @Route("/productList", name="productList")
     */
    public function listProduct(): Response
    {
        return $this->render('product/listProduct.html.twig');
    }
    /**
     * @Route("/cartItem", name="cartItem")
     */
    public function viewCart(): Response
    {
        return $this->render('product/cartItem.html.twig');
    }
}
