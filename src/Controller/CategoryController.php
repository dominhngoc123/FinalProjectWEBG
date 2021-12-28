<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\throwException;

/**
 * @Route("/category")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="cate")
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('category/index.html.twig', [
            'categories'=>$categoryRepository->findAll()
        ]);
    }

    /**
     * @Route("/add", name="add_category")
     */
    public function createCate(Request $request): Response
    {
        // Khởi tạo đối tượng
        $category = new Category();
        // Tạo form
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        // Kiểm tra form có submit hay không
        // Và data đã valid chưa
        if ($form->isSubmitted() && $form->isValid())
        {
           
            $manager = $this->getDoctrine()->getManager();
            //Thêm các data cần thiết
            $category->setCreateAt(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', time())));
            //Cứ bổ sung dòng này sau này thay thế bằng data từ session
            $category->setCreateBy("TrangBT");
            $manager->persist($category);
            $manager->flush();
            $this->addFlash('success', 'Create category success!!');
            return $this->redirectToRoute('category', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('category/add.html.twig', [
            'categoryForm' => $form,
        ]);
    }

    /**
     * @Route("/{id}/update", name="update_category", methods={"GET", "POST"})
     */

    public function updateCate(Request $request, Category $category): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $category->setUpdateAt(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', time())));
            //Cứ bổ sung dòng này sau này thay thế bằng data từ session
            $category->setUpdateBy("Trang updated");
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Update category success!!');
            return $this->redirectToRoute('category', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('category/edit.html.twig', [
            'category' => $category,
            'categoryForm' => $form,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete_category")
     */

    public function deleteCate($id): Response
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        if ($category == null)
        {
            $this->addFlash('error', 'Category does not exist');
        }
        else
        {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($category);
            $manager->flush();
            $this->addFlash('success', 'Delete category success!!');
        }
        return $this->redirectToRoute('category', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}/show", name="show_category", methods={"GET"})
     */
    public function GetByID(Category $category): Response
    {
        return $this->render('category/show.html.twig', [
            'category' => $category,
        ]);
    }

    /**
     * @Route("/search", name="search_category_by_name")
     */
    public function searchCate(CategoryRepository $categoryRepository, $category_name)
    {
        $categories = $categoryRepository->searchCateByName($category_name);
        return $this->render("category/index.html.twig", [
            'categories' => $categories
        ]);
    }

}
