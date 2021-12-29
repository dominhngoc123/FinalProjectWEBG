<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderDetail;
use App\Form\OrderDetailType;
use App\Repository\OrderDetailRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/order/detail")
 */
class OrderDetailController extends AbstractController
{
    /**
     * @Route("/{id}/add", name="add_order_detail")
     */
    public function add(Request $request, $id, OrderDetailRepository $orderDetailRepo): Response
    {
        $order = $this->getDoctrine()->getRepository(Order::class)->find($id);
        $previous_orderDetails = $orderDetailRepo->findOrderDetailByOrder($order->getID());
        $orderDetail = new OrderDetail();
        $orderDetail->setOrder($order);
        $form = $this->createForm(OrderDetailType::class, $orderDetail);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $book = $form["Book"]->getData();
            $orderDetail->setCurrentPrice($book->getBookPrice());
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($orderDetail);
            $manager->flush();
            $this->addFlash('success', 'Add product to order success');
            return $this->redirectToRoute('add_order_detail', [
                'orderDetails' => $previous_orderDetails,
                'orderDetailForm' => $form,
                'id' => $order->getID()
            ], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('order_detail/add.html.twig', [
            'orderDetails' => $previous_orderDetails,
            'orderDetailForm' => $form
        ]);
    }

    /**
     * @Route("/{id}/update", name="update_order_detail")
     */
    public function update(Request $request, Order $order, $id): Response
    {
        $orderDetail = $this->getDoctrine()->getRepository()->find($id);
        if ($orderDetail != null)
        {
            $form = $this->createForm(OrderDetailType::class, $orderDetail);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid())
            {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($orderDetail);
                $manager->flush();
                $this->addFlash('success', 'Update order success');
            }
        }
        else
        {
            $this->addFlash('error', 'Order detail does not exist');
        }
        return $this->redirectToRoute('view_order', [
            'order' => $order
        ], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}/remove", name="remove_order_detail")
     */
    public function remove($id): Response
    {
        $orderDetail = $this->getDoctrine()->getRepository(OrderDetail::class)->find($id);
        if ($orderDetail != null)
        {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($orderDetail);
            $manager->flush();
            $this->addFlash('success', 'Delete order detail success');
        }
        else
        {
            $this->addFlash('error', 'Order detail does not exist');
        }
        return $this->redirectToRoute('view_order', [
            'id' => $orderDetail->getOrder()->getId()
        ], Response::HTTP_SEE_OTHER);
    }
}
