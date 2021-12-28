<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(BookRepository $bookRepository): Response
    {
            $books = $this->getDoctrine()->getRepository(Book::class)->findAll();
            $news = $bookRepository->getNewProduct();
            return $this->render("home/index.html.twig",
            [
                'books' => $books,
                'news' => $news
            ]);
    }
      /**
     * @Route("/product/detail/{id}", name="product_detail")
     */
    public function bookDetail($id) {
        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);
        if ($book == null) {
            $this->addFlash("Error", "Book not exist");
            return $this->redirectToRoute("book");
        }
        return $this->render("product/details.html.twig",
        [
            'book' => $book
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
