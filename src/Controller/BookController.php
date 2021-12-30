<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookFormType;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Request;
use function PHPUnit\Framework\throwException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


/**
 * @Route("/book")
 */
class BookController extends AbstractController
{
    /**
    * @Route("/", name="book")
    */
    public function bookIndex() {
        $books = $this->getDoctrine()->getRepository(Book::class)->findAll();
        return $this->render("book/index.html.twig",
        [
            'books' => $books
        ]);
    }

    /**
     * @Route("/detail/{id}", name="book_detail")
     */
    public function bookDetail($id) {
        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);
        if ($book == null) {
            $this->addFlash("Error", "Book not exist");
            return $this->redirectToRoute("book");
        }
        return $this->render("book/show.html.twig",
        [
            'book' => $book
        ]);
    }

    /** 
     * @Route("/delete/{id}", name="book_delete")
     */
    public function bookDelete($id) {
        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);
        if ($book == null) {
            $this->addFlash("Error", "Book delete failed");  
        } else {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($book);
            $manager->flush();
            $this->addFlash("Success", "Book delete succeed"); 
        }
        return $this->redirectToRoute("book");
    }

    /**
     * @Route("/add", name="add_book")
     */
    public function bookAdd(Request $request) {
        $book = new Book();
        $form = $this->createForm(BookFormType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           $image = $book->getBookImage();
           $imgName = uniqid(); //unique id
           $imgExtension = $image->guessExtension();
           $imageName = $imgName . "." . $imgExtension;
           try {
             $image->move(
                 $this->getParameter('BookImage'), $imageName
             );  
           } catch (FileException $e) {
               throwException($e);
           }
           //B6: lưu tên ảnh vào DB
           $book->setBookImage($imageName);
           $book->setCreateAt(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', time())));
           $book->setCreateBy("tester");
            //đẩy dữ liệu từ form vào DB
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($book);
            $manager->flush();

            $this->addFlash("Success", "Add book succeed");
            return $this->redirectToRoute("book");
        }

        return $this->renderForm("book/add.html.twig",
        [
            'bookForm' => $form
        ]);
    }

    /**
     * @Route("/edit/{id}", name="book_edit")
     */
    public function bookEdit(Request $request, $id) {
        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);
        $form = $this->createForm(BookFormType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['BookImage']->getData();
            if ($file != null) {
                $image = $book->getBookImage();
                $imgName = uniqid();
                $imgExtension = $image->guessExtension();
                $imageName = $imgName . "." . $imgExtension;
                try {
                    $image->move($this->getParameter('BookImage'), $imageName);
                } catch (FileException $e) {
                    throwException($e);
                }
                $book->setBookImage($imageName);
            }
            
            $book->setCreateAt(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', time())));
            $book->setCreateBy("tester");
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($book);
            $manager->flush();

            $this->addFlash("Success", "Edit book succeed");
            return $this->redirectToRoute("book");
        }

        return $this->renderForm("book/edit.html.twig",
        [
            'bookForm' => $form
        ]);
    }

    /**
     * @Route("/sort/id/asc", name="sort_book_id_asc")
     */
    public function sortBookByIdAsc (BookRepository $bookRepository) {
        $books = $bookRepository->sortBookIdAsc();
        return $this->render("book/index.html.twig",
        [
            'books' => $books
        ]);
    }

     /**
     * @Route("/sort/id/desc", name="sort_book_id_desc")
     */
    public function sortBookByIdDesc (BookRepository $bookRepository) {
        $books = $bookRepository->sortBookIdDesc();
        return $this->render("book/index.html.twig",
        [
            'books' => $books
        ]);
    }

    /**
     * @Route("/search", name="search_book")
     */
    public function searchBookByTitle (BookRepository $bookRepository, Request $request) {
        $title = $request->get("searchContent");
        $books = $bookRepository->searchByTitle($title);
        return $this->render("book/index.html.twig",
        [
            'books' => $books
        ]);
    }
}
