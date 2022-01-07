<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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
     * @Route("/add", name="add_user")
     */
    public function addUser(Request $request, UserPasswordHasherInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $user->setRoles(['ROLE_USER']);
            $user->setUsername($form->get('username')->getData());
            $user->setUserFullName($form->get('user_full_name')->getData());
            $user->setUserAddress($form->get('user_address')->getData());
            $user->setUserDOB(\DateTime::createFromFormat('Y-m-d',
                $form->get('user_DOB')->getData()->format('Y-m-d')));
            $user->setUserEmail($form->get('user_email')->getData());
            $user->setUserPhone($form->get('user_phone')->getData());
            $user->setPassword(
                $encoder->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $user->setCreateAt(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', time())));
            //Cứ bổ sung dòng này sau này thay thế bằng data từ session
            $security = unserialize($request->getSession()->get("_security_main"));
            $user->setCreateBy($security->getUser()->getUserFullName());
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', 'Add user success');
            return $this->redirectToRoute('user', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('user/add.html.twig', [
            'userForm' => $form,
        ]);
    }

    /**
     * @Route("/{id}/upgrade", name="upgrade_user", methods={"GET", "POST"})
     */
    public function upgradeUser($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        if ($user != null)
        {
            $user->setRoles(['ROLE_ADMIN']);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Upgrade user success');
        }
        else
        {
            $this->addFlash('error', 'User does not exist');
        }
        return $this->redirectToRoute('user', [], Response::HTTP_SEE_OTHER);
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

    /**
     * @Route("/sort/fullname/asc", name="sort_by_full_name_asc")
     */
    public function sortByFullnameASC(UserRepository $repository)
    {
        return $this->render("user/index.html.twig", [
            'users' => $repository->sortUserByFullNameASC()
        ]);
    }

    /**
     * @Route("/sort/fullname/desc", name="sort_by_full_name_desc")
     */
    public function sortByFullnameDESC(UserRepository $repository)
    {
        return $this->render("user/index.html.twig", [
            'users' => $repository->sortUserByFullNameDESC()
        ]);
    }

    /**
     * @Route("/sort/email/asc", name="sort_by_email_asc")
     */
    public function sortByEmailASC(UserRepository $repository)
    {
        return $this->render("user/index.html.twig", [
            'users' => $repository->sortUserByEmailASC()
        ]);
    }

    /**
     * @Route("/sort/email/desc", name="sort_by_email_desc")
     */
    public function sortByEmailDESC(UserRepository $repository)
    {
        return $this->render("user/index.html.twig", [
            'users' => $repository->sortUserByEmailDESC()
        ]);
    }

    /**
     * @Route("/sort/username/asc", name="sort_by_username_asc")
     */
    public function sortByUsernameASC(UserRepository $repository)
    {
        return $this->render("user/index.html.twig", [
            'users' => $repository->sortUserByUsernameASC()
        ]);
    }

    /**
     * @Route("/sort/username/desc", name="sort_by_username_desc")
     */
    public function sortByUsernameDESC(UserRepository $repository)
    {
        return $this->render("user/index.html.twig", [
            'users' => $repository->sortUserByUsernameDESC()
        ]);
    }

    /**
     * @Route("/sort/roles/asc", name="sort_by_roles_asc")
     */
    public function sortByRolesASC(UserRepository $repository)
    {
        return $this->render("user/index.html.twig", [
            'users' => $repository->sortUserByRolesASC()
        ]);
    }

    /**
     * @Route("/sort/roles/desc", name="sort_by_roles_desc")
     */
    public function sortByRolesDESC(UserRepository $repository)
    {
        return $this->render("user/index.html.twig", [
            'users' => $repository->sortUserByRolesDESC()
        ]);
    }
}
