<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderDetail;
use App\Form\OrderDetailType;
use App\Repository\OrderDetailRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/order/detail")
 */
class OrderDetailController extends AbstractController
{
    /**
     * @Route("/{add_more}/add", name="add_order_detail")
     */
    public function add(Request $request, Order $order, bool $add_more): Response
    {
        $orderDetail = new OrderDetail();
        $orderDetail->setOrder($order);
        $form = $this->createForm(OrderDetailType::class, $orderDetail);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $book = $form["book"]->getData();
            $orderDetail->setCurrentPrice($book->getBookPrice());
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($orderDetail);
            $manager->flush();
            if ($add_more)
            {
                $repo = new OrderDetailRepository();
                return $this->redirectToRoute('add_order_detail', [

                ], Response::HTTP_SEE_OTHER);
            }
            return $this->redirectToRoute('order', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('order_detail/add.html.twig', [
            'form' => $form
        ]);
    }

    /**
     * @Route("/{id}/update", name="update_order_detail")
     */
    public function update(Request $request, OrderDetail $orderDetail): Response
    {

    }

    /**
     * @Route("/{id}/remove", name="remove_order_detail")
     */
    public function remove(Request $request, Order $order): Response
    {

    }
}
