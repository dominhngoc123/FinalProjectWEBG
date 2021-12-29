<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function index(SessionInterface $session, BookRepository $bookRepository): Response
    {
        $cart = $session->get('cart', []);
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
                'total' => $total,
                'message' => ''
            ]);
        }
        return $this->render('cart/index.html.twig', [
            'message' => 'No item in cart',
            'total' => 0
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
}
