<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
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
 * @Route("/user")
 */
class UserController extends AbstractController
{
     /**
     * @Route("/", name="user")
     */
    public function index(UserRepository $repository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $repository->findAll()
        ]);
    }

    /**
     * @Route("/{id}/update", name="update_user", methods={"GET", "POST"})
     */
    public function updateUser(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $user->setUpdateAt(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', time())));
            //Cứ bổ sung dòng này sau này thay thế bằng data từ session
            $security = unserialize($request->getSession()->get("_security_main"));
            $user->setUpdateBy($security->getUser()->getUserFullName());
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Update user success');
            return $this->redirectToRoute('user', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'userForm' => $form,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete_user")
     */
    public function deleteUser($id): Response
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        if ($user == null)
        {
            $this->addFlash('error', 'User does not exist');
        }
        else
        {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($user);
            $manager->flush();
            $this->addFlash('success', 'Delete user success');
        }
        return $this->redirectToRoute('user', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}/show", name="show_user", methods={"GET"})
     */
    public function GetByID(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/search", name="search_user_by_name")
     */
    public function searchUser(UserRepository $userRepository, Request $request)
    {
        $searchContent = $request->get('searchContent');
        $users = $userRepository->searchUser($searchContent);
        return $this->render("user/index.html.twig", [
            'users' => $users
        ]);
    }
}
