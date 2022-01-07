<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderDetail;
use App\Form\OrderType;
use App\Repository\OrderDetailRepository;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_ADMIN")
 *
 * @Route("/order")
 */
class OrderController extends AbstractController
{
    /**
     * @Route("/", name="order")
     */
    public function index(): Response
    {
        $orders = $this->getDoctrine()->getRepository(Order::class)->findAll();
        return $this->render('order/index.html.twig', [
            'orders' => $orders
        ]);
    }

    /**
     * @Route("/add", name="admin_add_order")
     */
    public function adminAdd(Request $request): Response
    {
        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $order->setCreateAt(\DateTime::createFromFormat('Y-m-d H:i:s',
                date('Y-m-d H:i:s', time())));
            $security = unserialize($request->getSession()->get("_security_main"));
            $order->setCreateBy($security->getUser()->getUserFullName());
            $order->setStatus("PENDING");
            $manager->persist($order);
            $manager->flush();
            $this->addFlash('success',
                'Create order success. Now you can add product to order.');
            return $this->redirectToRoute('add_order_detail', [
                'add_more' => true,
                'id' => $order->getId()
            ], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('order/add.html.twig', [
            'orderForm' => $form
        ]);
    }

    /**
     * @Route("/{id}/update", name="update_order", methods={"GET", "POST"})
     */
    public function update(Request $request, Order $order): Response
    {
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $order->setUpdateAt(\DateTime::createFromFormat('Y-m-d H:i:s',
                date('Y-m-d H:i:s', time())));
            $security = unserialize($request->getSession()->get("_security_main"));
            $order->setUpdateBy($security->getUser()->getUserFullName());
            $manager->persist($order);
            $manager->flush();
            $this->addFlash('success', 'Update order success!!');
            return $this->redirectToRoute('order', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('order/edit.html.twig', [
            'orderForm' => $form,
            'id' => $order->getId()
        ]);
    }

    /**
     * @Route("/{id}/delete", name="delete_order")
     */
    public function delete($id, OrderDetailRepository $detailRepository)
    {
        $order = $this->getDoctrine()->getRepository(Order::class)->find($id);
        if ($order == null)
        {
            $this->addFlash('error', 'Order does not exist');
        }
        else
        {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($order);
            $manager->flush();
            $this->addFlash('success', 'Delete order success');
        }
        return $this->redirectToRoute('order', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}/view", name="view_order")
     */
    public function viewDetail($id)
    {
        $order = $this->getDoctrine()->getRepository(Order::class)->find($id);
        if ($order != null)
        {
            return $this->render('order/view.html.twig', [
                'order' => $order
            ]);
        }
        $this->addFlash('error', 'Order does not exist');
        return $this->redirectToRoute('order', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}/update/status", name="update_order_status")
     */
    public function updateOrderStatus($id, OrderRepository $repository)
    {
        $order = $repository->find($id);
        if ($order->getStatus() == "COMPLETE")
        {
            $this->addFlash('error', 'Cannot update order status');
        }
        else
        {
            $order->setStatus("COMPLETE");
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($order);
            $manager->flush();
            $this->addFlash('success', 'Update status success');
        }
        return $this->redirectToRoute('order', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/search-result", name="search_order_by_creator")
     */
    public function search(Request $request, OrderRepository $repository): Response
    {
        $searchContent = $request->get('searchContent');
        $orders = $repository->getOrdersByUser($searchContent);
        return $this->render('order/index.html.twig', [
            'orders' => $orders
        ]);
    }

    /**
     * @Route("/sort-by-customer-name-desc", name="sort_by_customer_name_desc")
     */
    public function sortByCustomerNameDESC(OrderRepository $repository)
    {
        $orders = $repository->sortByCustomerNameDESC();
        return $this->render('order/index.html.twig', [
            'orders' => $orders
        ]);
    }

    /**
     * @Route("/sort-by-customer-name-asc", name="sort_by_customer_name_asc")
     */
    public function sortByCustomerNameASC(OrderRepository $repository)
    {
        $orders = $repository->sortByCustomerNameASC();
        return $this->render('order/index.html.twig', [
            'orders' => $orders
        ]);
    }

    /**
     * @Route("/sort-by-date-asc", name="sort_by_date_asc")
     */
    public function sortByDateASC(OrderRepository $repository)
    {
        $orders = $repository->sortByDateASC();
        return $this->render('order/index.html.twig', [
            'orders' => $orders
        ]);
    }

    /**
     * @Route("/sort-by-date-desc", name="sort_by_date_desc")
     */
    public function sortByDateDESC(OrderRepository $repository)
    {
        $orders = $repository->sortByDateDESC();
        return $this->render('order/index.html.twig', [
            'orders' => $orders
        ]);
    }

    /**
     * @Route("/history", name="view_history")
     */
    public function getOrderHistory(OrderRepository $orderRepository, UserRepository $userRepository)
    {
        $users = $orderRepository->getOrderOverview();
        return $this->render('order/history.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("{id}/history/detail", name="view_detail_history")
     */
    public function getHistoryDetail($id, OrderRepository $orderRepository, UserRepository $userRepository)
    {
        $user = $userRepository->find($id);
        $orders = $orderRepository->getHistory($id);
        return $this->render('order/history_detail.html.twig', [
            'user' => $user,
            'orders' => $orders
        ]);
    }
}
