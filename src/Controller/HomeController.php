<?php

namespace App\Controller;

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
        return $this->render('home/index.html.twig');
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
