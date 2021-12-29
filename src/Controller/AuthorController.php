<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\throwException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @IsGranted("ROLE_ADMIN")
 *
 * @Route("/author")
 */
class AuthorController extends AbstractController
{
    /**
     * @Route("/", name="author")
     */
    public function index(AuthorRepository $repository): Response
    {
        return $this->render('author/index.html.twig', [
            'authors' => $repository->findAll()
        ]);
    }

    /**
     * @Route("/add", name="add_author")
     */
    public function Create(Request $request): Response
    {
        // Khởi tạo đối tượng
        $author = new Author();
        // Tạo form
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);
        // Kiểm tra form có submit hay không
        // Và data đã valid chưa
        if ($form->isSubmitted() && $form->isValid())
        {
            // Lấy image của author trong form
            $img = $author->getAuthorImage();
            // Kiểm tra image có null hay không
            if ($img != null) {
                // Tạo tên duy nhất
                $tmpName = uniqid();
                // Lấy extension của ảnh
                $tmpExtension = $img->guessExtension();
                //Thêm phần kiểm tra extension
                // Cộng 2 chuỗi thành tên ảnh
                $imageName = $tmpName . '.' . $tmpExtension;
                try {
                    //Di chuyển ảnh
                    $img->move(
                        $this->getParameter('AuthorImage'), $imageName
                    );
                    /* Note: cần khai báo đường dẫn thư mục chứa ảnh
                     ở file config/services.yaml */
                } catch (FileException $exception) {
                    throwException($exception);
                }
                //Gán tên cho author
                $author->setAuthorImage($imageName);
            }
            $manager = $this->getDoctrine()->getManager();
            //Thêm các data cần thiết
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $author->setCreateAt(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', time())));
            //Cứ bổ sung dòng này sau này thay thế bằng data từ session
            $security = unserialize($request->getSession()->get("_security_main"));
            $author->setCreateBy($security->getUser()->getUserFullName());
            $manager->persist($author);
            $manager->flush();
            $this->addFlash('success', 'Create author success!!');
            return $this->redirectToRoute('author', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('author/add.html.twig', [
            'authorForm' => $form,
        ]);
    }

    /**
     * @Route("/{id}/update", name="update_author", methods={"GET", "POST"})
     */
    public function Update(Request $request, Author $author): Response
    {
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $img = $author->getAuthorImage();
            if ($img != null)
            {
                $tmpName = uniqid();
                $tmpExtension = $img->guessExtension();
                //Thêm phần kiểm tra extension
                $imageName = $tmpName . '.' . $tmpExtension;
                try {
                    $img->move(
                        $this->getParameter('AuthorImage'), $imageName
                    );
                    /* Note: cần khai báo đường dẫn thư mục chứa ảnh
                     ở file config/services.yaml */
                }
                catch (FileException $exception)
                {
                    throwException($exception);
                }
                $author->setAuthorImage($imageName);
            }
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $author->setUpdateAt(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', time())));
            //Cứ bổ sung dòng này sau này thay thế bằng data từ session
            $security = unserialize($request->getSession()->get("_security_main"));
            $author->setUpdateBy($security->getUser()->getUserFullName());
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Update author success');
            return $this->redirectToRoute('author', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('author/edit.html.twig', [
            'author' => $author,
            'authorForm' => $form,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete_author")
     */
    public function delete($id): Response
    {
        $author = $this->getDoctrine()->getRepository(Author::class)->find($id);
        if ($author == null)
        {
            $this->addFlash('error', 'Author does not exist');
        }
        else
        {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($author);
            $manager->flush();
            $this->addFlash('success', 'Delete author success');
        }
        return $this->redirectToRoute('author', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}/show", name="show_author", methods={"GET"})
     */
    public function GetByID(Author $author): Response
    {
        return $this->render('author/show.html.twig', [
            'author' => $author,
        ]);
    }

    /**
     * return Author[]
     * @Route("/sort/fullname/desc", name="sort_author_by_fullname_desc")
     */
    public function sortByFullNameDesc(AuthorRepository $repository): Response
    {
        $authors = $repository->sortByNameDesc();
        return $this->render("author/index.html.twig", [
            'authors' => $authors
        ]);
    }

    /**
     * return Author[]
     * @Route("/sort/fullname/asc", name="sort_author_by_fullname_asc")
     */
    public function sortByFullNameAsc(AuthorRepository $repository): Response
    {
        $authors = $repository->sortByNameAsc();
        return $this->render("author/index.html.twig", [
            'authors' => $authors
        ]);
    }

    /**
     * return Author[]
     * @Route("/sort/stage_name/desc", name="sort_author_by_stage_name_desc")
     */
    public function sortByStageNameDesc(AuthorRepository $repository): Response
    {
        $authors = $repository->sortByStageNameDesc();
        return $this->render("author/index.html.twig", [
            'authors' => $authors
        ]);
    }

    /**
     * @Route("/sort/stage_name/asc", name="sort_author_by_stage_name_asc")
     */
    public function sortByStageNameAsc(AuthorRepository $repository): Response
    {
        $authors = $repository->sortByStageNameAsc();
        return $this->render("author/index.html.twig", [
            'authors' => $authors
        ]);
    }

    /**
     * @Route("/search-result", name="search_author")
     */
    public function search(AuthorRepository $repository, Request $request): Response
    {
        $searchContent = $request->get('searchContent');
        $authors = $repository->findByAuthorNameOrStageName($searchContent);
        return $this->render("author/index.html.twig", [
            'authors' => $authors
        ]);
    }
}
