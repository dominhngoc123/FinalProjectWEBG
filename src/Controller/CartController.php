<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderDetail;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use App\Repository\TypeRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cart")
 */
class CartController extends AbstractController
{
    /**
     * @Route("/", name="view_cart")
     */
    public function index(SessionInterface $session, BookRepository $bookRepository,CategoryRepository $categoryRepository, TypeRepository $typeRepository): Response
    {
        $cart = $session->get('cart', []);
        $populars = $bookRepository->getPopularProduct();
        $category = $categoryRepository->findAll();
        $type= $typeRepository->findAll();
        if ($cart != null)
        {
            $cartWithData = [];
            foreach($cart as $bookId => $quantity)
            {
                $book = $bookRepository->getBookById($bookId);
                if ($book != null)
                {
                    $cartWithData[] = [
                        'book' => $book,
                        'quantity' => $quantity,
                        'total_item' => $book->getBookPrice() * $quantity
                    ];
                }
            }

            $total=0;
            foreach($cartWithData as $item)
            {
                $totalItem = $item['book']->getBookPrice() * $item['quantity'];
                $total += $totalItem;

            }
            return $this->render('cart/index.html.twig', [
                'items' => $cartWithData,
                'populars' => $populars,
                'types' => $type,
                'categories' => $category,
                'total' => $total,
                'message' => ''
            ]);
        }
        return $this->render('cart/index.html.twig', [
            'message' => 'No item in cart',
            'total' => 0,
            'populars' => $populars,
            'types' => $type,
            'categories' => $category,
        ]);
    }

    /**
     * @Route("/add/{bookId}", name="add_to_cart")
     */
    public function add($bookId, SessionInterface $session): Response
    {
        $cart = $session->get('cart', []);
        if(!empty($cart[$bookId])) {
            $cart[$bookId]++;
        } else {
            $cart[$bookId] = 1;
        }
        $session->set('cart', $cart);
        return $this->redirectToRoute('view_cart');
    }

    /**
     * @Route("/increase/{bookId}", name="cart_increase")
     */
    public function increase($bookId, SessionInterface $session, BookRepository $bookRepository): Response
    {
        $cart = $session->get('cart', []);
        $book = $bookRepository->getBookById($bookId);
        if(!empty($cart[$bookId])) {
            $cart[$bookId]++;
        }
        $session->set('cart', $cart);
        return $this->redirectToRoute('view_cart');
    }

    /**
     * @Route("/decrease/{bookId}", name="cart_decrease")
     */
    public function decrease($bookId, SessionInterface $session): Response
    {
        $cart = $session->get('cart', []);
        if(!empty($cart[$bookId])) {
            $cart[$bookId]--;
        }
        $session->set('cart', $cart);
        return $this->redirectToRoute('view_cart');
    }

    /**
     * @Route("/remove/{bookId}", name="remove_from_cart")
     */
    public function remove($bookId, SessionInterface $session): Response
    {
        $cart = $session->get('cart', []);
        if(!empty($cart[$bookId])){
            unset($cart[$bookId]);
        }
        $session->set('cart', $cart);
        return $this->redirectToRoute('view_cart');
    }

    /**
     * @Route("/checkout", name="checkout")
     */
    public function checkout(SessionInterface $session, Request $request, BookRepository $bookRepository, UserRepository $userRepository, CategoryRepository $categoryRepository, TypeRepository $typeRepository): Response
    {
        $cart = $session->get('cart', []);
        $populars = $bookRepository->getPopularProduct();
        $category = $categoryRepository->findAll();
        $type= $typeRepository->findAll();
        if ($cart == null)
        {
            $this->addFlash('error', 'Cart is empty');
        }
        else
        {
            $order = new Order();
            $security = unserialize($request->getSession()->get("_security_main"));
            $user = $userRepository->find($security->getUser()->getID());
            $order->setUser($user);
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $order->setCreateAt(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', time())));
            $order->setCreateBy($security->getUser()->getUserFullName());
            $order->setStatus("PENDING");
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($order);
            foreach ($cart as $key => $value)
            {
                $book = $bookRepository->find($key);
                $orderDetail = new OrderDetail();
                $orderDetail->setCurrentPrice($book->getBookPrice());
                $orderDetail->setOrder($order);
                $orderDetail->setBook($book);
                $orderDetail->setQuantity($value);
                $manager->persist($orderDetail);
            }
            $manager->flush();
            $this->addFlash('success', 'Create order success');
            $cart = $session->set('cart', []);
        }
        return $this->redirectToRoute('view_cart', [
            'message' => 'No item in cart',
            'total' => 0,
            'populars' => $populars,
            'types' => $type,
            'categories' => $category,
        ]);
    }
}
