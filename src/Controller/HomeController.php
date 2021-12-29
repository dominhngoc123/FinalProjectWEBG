<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Category;
use App\Entity\Type;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use App\Repository\TypeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(BookRepository $bookRepository, CategoryRepository $categoryRepository, TypeRepository $typeRepository): Response
    {
            // $books = $this->getDoctrine()->getRepository(Book::class)->findAll();
            $books = $bookRepository->getHotProduct();
            $news = $bookRepository->getNewProduct();
            $category = $categoryRepository->findAll();
            $type= $typeRepository->findAll();
            return $this->render("home/index.html.twig",
            [
                'books' => $books,
                'news' => $news,
                'types' => $type,
                'categories' => $category
            ]);
    }
      /**
     * @Route("/product/detail/{id}", name="product_detail")
     */
    public function bookDetail($id,BookRepository $bookRepository, CategoryRepository $categoryRepository, TypeRepository $typeRepository) {
        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);
        $sellers = $bookRepository->getSellerProduct();
        $populars = $bookRepository->getPopularProduct();
        $category = $categoryRepository->findAll();
        $type= $typeRepository->findAll();
        if ($book == null) {
            $this->addFlash("Error", "Book not exist");
            return $this->redirectToRoute("book");
        }
        return $this->render("product/details.html.twig",
        [
            'book' => $book,
            'sellers' => $sellers,
            'populars' => $populars,
            'types' => $type,
            'categories' => $category
        ]);
    }
     /**
     * @Route("/category/detail/{id}", name="category_detail")
     */
    public function categoryDetail($id, BookRepository $bookRepository, CategoryRepository $categoryRepository, TypeRepository $typeRepository) {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        $category1 = $categoryRepository->findAll();
        $type= $typeRepository->findAll();
        if ($category == null) {
            $this->addFlash("Error", "Category not exist");
            return $this->redirectToRoute("home");
        }
        return $this->render("product/listProduct.html.twig",
        [
            'category' => $category,
            'sellers' => $bookRepository->getSellerProduct(),
            'types' => $type,
            'categories' => $category1
        ]);
    }
         /**
     * @Route("/type/detail/{id}", name="type_detail")
     */
    public function typeDetail($id,BookRepository $bookRepository, CategoryRepository $categoryRepository, TypeRepository $typeRepository) {
        $type = $this->getDoctrine()->getRepository(Type::class)->find($id);
        $category = $categoryRepository->findAll();
        $type1= $typeRepository->findAll();
        if ($type == null) {
            $this->addFlash("Error", "Type not exist");
            return $this->redirectToRoute("home");
        }
        return $this->render("product/listProduct.html.twig",
        [
            'type' => $type,
            'sellers' => $bookRepository->getSellerProduct(),
            'types' => $type1,
            'categories' => $category
        ]);
    }
     /**
     * @Route("/hotProduct", name="hot_product")
     */
    public function getHotProduct(BookRepository $bookRepository, CategoryRepository $categoryRepository, TypeRepository $typeRepository) {
        $books = $bookRepository->getHotProduct();
        $category1 = $categoryRepository->findAll();
        $type= $typeRepository->findAll();
        if ($books == null) {
            $this->addFlash("Error", "Category not exist");
            return $this->redirectToRoute("home");
        }
        return $this->render("product/listProduct.html.twig",
        [
            'hots' => $books,
            'sellers' => $bookRepository->getSellerProduct(),
            'types' => $type,
            'categories' => $category1
        ]);
    }
     /**
     * @Route("/newProduct", name="new_product")
     */
    public function getNewProduct(BookRepository $bookRepository, CategoryRepository $categoryRepository, TypeRepository $typeRepository) {
        $books = $bookRepository->getNewProduct();
        $category1 = $categoryRepository->findAll();
        $type= $typeRepository->findAll();
        if ($books == null) {
            $this->addFlash("Error", "Category not exist");
            return $this->redirectToRoute("home");
        }
        return $this->render("product/listProduct.html.twig",
        [
            'news' => $books,
            'sellers' => $bookRepository->getSellerProduct(),
            'types' => $type,
            'categories' => $category1
        ]);
    }
    /**
     * @Route("/product/search", name="search_book_by_title")
     */
    public function searchBookByTitle (BookRepository $bookRepository, Request $request,CategoryRepository $categoryRepository, TypeRepository $typeRepository) {
        $title = $request->get("title");
        $books = $bookRepository->searchByTitle($title);
        $category1 = $categoryRepository->findAll();
        $type= $typeRepository->findAll();
        return $this->render("product/searchResult.html.twig",
        [
            'variable' => $title, 
            'books' => $books,
            'sellers' => $bookRepository->getSellerProduct(),
            'types' => $type,
            'categories' => $category1
        ]);
    }
    /**
     * @Route("/cartItem", name="cartItem")
     */
    public function viewCart(): Response
    {
        return $this->render('product/cartItem.html.twig');
    }
}
