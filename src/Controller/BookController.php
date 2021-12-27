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


class BookController extends AbstractController
{
    /**
    * @Route("/booklist", methods="GET", name="book_list_api")
    */
    public function getBookList() : JsonResponse {
        $books = $this->getDoctrine()->getRepository(Book::class)->findAll();
        return $this->json(['books' => $books], 200);
    }
   
    /**
    * @Route("/book", name="book")
    */
    public function bookIndex() {
        $books = $this->getDoctrine()->getRepository(Book::class)->findAll();
        return $this->render("book/index.html.twig",
        [
            'books' => $books
        ]);
    }

    /**
     * @Route("/book/detail/{id}", name="book_detail")
     */
    public function bookDetail($id) {
        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);
        if ($book == null) {
            $this->addFlash("Error", "Book not exist");
            return $this->redirectToRoute("book_index");
        }
        return $this->render("book/detail.html.twig",
        [
            'book' => $book
        ]);
    }

    /** 
     * @IsGranted("ROLE_STAFF")
     * @Route("/book/delete/{id}", name="book_delete")
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
        return $this->redirectToRoute("book_index");
    }

    /**
     * @Route("/book/add", name="add_book")
     */
    public function bookAdd(Request $request) {
        $book = new Book();
        $form = $this->createForm(BookFormType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           //code xử lý việc upload ảnh
           //B1: lấy ảnh từ file upload
           $image = $book->getCover();
           //B2: đặt tên mới cho ảnh => đảm bảo mỗi ảnh sẽ có 1 tên duy nhất
           $imgName = uniqid(); //unique id
           //B3: lấy đuôi ảnh (image extension)
           $imgExtension = $image->guessExtension();
           //Note: cần edit code lại trong file Book Entity (Book.php)
           //B4: nối tên mới & đuôi ảnh thành tên hoàn chỉnh để lưu vào DB & thư mục
           $imageName = $imgName . "." . $imgExtension;
           //B5: di chuyển ảnh vào thư mục chỉ định
           try {
             $image->move(
                 $this->getParameter('book_cover'), $imageName
                 /* Note: cần khai báo đường dẫn thư mục chứa ảnh
                 ở file config/services.yaml */
             );  
           } catch (FileException $e) {
               throwException($e);
           }
           //B6: lưu tên ảnh vào DB
           $book->setCover($imageName);
       
            //đẩy dữ liệu từ form vào DB
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($book);
            $manager->flush();

            //hiển thị thông báo và redirect về trang book index
            $this->addFlash("Success", "Add book succeed");
            return $this->redirectToRoute("book_index");
        }

        return $this->renderForm("book/add.html.twig",
        [
            'bookForm' => $form
        ]);
    }

    /**
     * @IsGranted("ROLE_STAFF")
     * @Route("/book/edit/{id}", name="book_edit")
     */
    public function bookEdit(Request $request, $id) {
        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //code xử lý việc upload ảnh
            //B1: lấy dữ liệu ảnh từ form
            $file = $form['cover']->getData();
            //B2: check xem ảnh có null không
            if ($file != null) { //người dùng update ảnh mới
                //B3: lấy ảnh từ file upload
                $image = $book->getCover();
                //B4: đặt tên mới cho ảnh
                $imgName = uniqid();
                //B5: lấy extension của file ảnh
                $imgExtension = $image->guessExtension();
                //B6: nối tên mới và extension thành tên file hoàn chỉnh
                $imageName = $imgName . "." . $imgExtension;
                //B7: di chuyển ảnh vào thư mục project
                try {
                    $image->move($this->getParameter('book_cover'), $imageName);
                } catch (FileException $e) {
                    throwException($e);
                }
                //B8: lưu tên ảnh vào DB
                $book->setCover($imageName);
            }

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($book);
            $manager->flush();

            $this->addFlash("Success", "Edit book succeed");
            return $this->redirectToRoute("book_index");
        }

        return $this->renderForm("book/edit.html.twig",
        [
            'bookForm' => $form
        ]);
    }

    /**
     * @Route("/book/sort/id/asc", name="sort_book_id_asc")
     */
    public function sortBookByIdAsc (BookRepository $bookRepository) {
        $books = $bookRepository->sortBookIdAsc();
        return $this->render("book/index.html.twig",
        [
            'books' => $books
        ]);
    }

     /**
     * @Route("/book/sort/id/desc", name="sort_book_id_desc")
     */
    public function sortBookByIdDesc (BookRepository $bookRepository) {
        $books = $bookRepository->sortBookIdDesc();
        return $this->render("book/index.html.twig",
        [
            'books' => $books
        ]);
    }

    /**
     * @Route("/book/search", name="search_book")
     */
    public function searchBookByTitle (BookRepository $bookRepository, Request $request) {
        $title = $request->get("title");
        $books = $bookRepository->searchByTitle($title);
        return $this->render("book/index.html.twig",
        [
            'books' => $books
        ]);
    }
}
