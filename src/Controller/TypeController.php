<?php

namespace App\Controller;

use App\Entity\Type;
use App\Form\Type2Type;
use App\Repository\TypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\throwException;

/**
 * @Route("/type")
 */
class TypeController extends AbstractController
{
     /**
     * @Route("/", name="type")
     */
    public function index(TypeRepository $typeRepository,): Response
    {
        return $this->render('type/index.html.twig', [
            'types'=>$typeRepository->findAll()
        ]);
    }

    /**
     * @Route("/add", name="add_type")
     */
    public function createCate(Request $request): Response
    {
        // Khởi tạo đối tượng
        $type = new Type();
        // Tạo form
        $form = $this->createForm(TypeType::class, $type);
        $form->handleRequest($request);
        // Kiểm tra form có submit hay không
        // Và data đã valid chưa
        if ($form->isSubmitted() && $form->isValid())
        {
           
            $manager = $this->getDoctrine()->getManager();
            //Thêm các data cần thiết
            $type->setCreateAt(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', time())));
            //Cứ bổ sung dòng này sau này thay thế bằng data từ session
            $type->setCreateBy("TrangBT");
            $manager->persist($type);
            $manager->flush();
            $this->addFlash('success', 'Create type success!!');
            return $this->redirectToRoute('type', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('type/add.html.twig', [
            'typeForm' => $form,
        ]);
    }

    /**
     * @Route("/{id}/update", name="update_type", methods={"GET", "POST"})
     */

    public function updateCate(Request $request, Type $type): Response
    {
        $form = $this->createForm(TypeType::class, $type);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $type->setUpdateAt(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', time())));
            //Cứ bổ sung dòng này sau này thay thế bằng data từ session
            $type->setUpdateBy("Trang updated");
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Update type success!!');
            return $this->redirectToRoute('type', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('type/edit.html.twig', [
            'type' => $type,
            'typeForm' => $form,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete_type")
     */

    public function deleteCate($id): Response
    {
        $type = $this->getDoctrine()->getRepository(Type::class)->find($id);
        if ($type == null)
        {
            $this->addFlash('error', 'Type does not exist');
        }
        else
        {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($type);
            $manager->flush();
            $this->addFlash('success', 'Delete type success!!');
        }
        return $this->redirectToRoute('type', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}/show", name="show_type", methods={"GET"})
     */
    public function GetByID(Type $type): Response
    {
        return $this->render('type/show.html.twig', [
            'type' => $type,
        ]);
    }

    /**
     * @Route("/search", name="search_type_by_name")
     */
    public function searchType(TypeRepository $typeRepository, $type_name)
    {
        $types = $typeRepository->searchTypeByName($type_name);
        return $this->render("type/index.html.twig", [
            'types' => $types
        ]);
    }
}

