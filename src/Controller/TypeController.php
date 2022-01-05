<?php

namespace App\Controller;

use App\Entity\Type;
use App\Form\TypeBookType;
use App\Repository\TypeRepository;
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
 * @Route("/type")
 */
class TypeController extends AbstractController
{
     /**
     * @Route("/", name="type")
     */
    public function index(TypeRepository $typeRepository): Response
    {
        return $this->render('type/index.html.twig', [
            'types'=>$typeRepository->findAll()
        ]);
    }

    /**
     * @Route("/add", name="add_type")
     */
    public function createType(Request $request): Response
    {
        // Khởi tạo đối tượng
        $type = new Type();
        // Tạo form
        $form = $this->createForm(TypeBookType::class, $type);
        $form->handleRequest($request);
        // Kiểm tra form có submit hay không
        // Và data đã valid chưa
        if ($form->isSubmitted() && $form->isValid())
        {
           
            $manager = $this->getDoctrine()->getManager();
            //Thêm các data cần thiết
            $type->setCreateAt(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', time())));
            $security = unserialize($request->getSession()->get("_security_main"));
            $type->setCreateBy($security->getUser()->getUserFullName());
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

    public function updateType(Request $request, Type $type): Response
    {
        $form = $this->createForm(TypeBookType::class, $type);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $type->setUpdateAt(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', time())));
            $security = unserialize($request->getSession()->get("_security_main"));
            $type->setUpdateBy($security->getUser()->getUserFullName());$this->getDoctrine()->getManager()->flush();
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

    public function deleteType($id): Response
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
    public function searchType(TypeRepository $typeRepository, Request $request)
    {
        $keyWord = $request->get("type_name");
        $types = $typeRepository->searchTypeByName($keyWord);
        return $this->render("type/index.html.twig", [
            'types' => $types
        ]);
    }

    /**
     * @Route("/sort/typename/desc", name="sort_type_by_name_desc")
     */
    public function sortTypeNameDesc(TypeRepository $typeRepository,): Response
    {
        $types = $typeRepository->sortTypeNameDesc();
        return $this->render("type/index.html.twig", [
            'types' => $types
        ]);
    }

    /**
     * @Route("/sort/typename/asc", name="sort_type_by_name_asc")
     */
    public function sortTypeNameAsc(TypeRepository $typeRepository,): Response
    {
        $types = $typeRepository->sortTypeNameAsc();
        return $this->render("type/index.html.twig", [
            'types' => $types
        ]);
    }
}


