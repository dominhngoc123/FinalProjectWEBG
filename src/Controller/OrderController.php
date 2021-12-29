<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderDetail;
use App\Form\OrderType;
use App\Repository\OrderDetailRepository;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/order")
 */
class OrderController extends AbstractController
{
    /**
     * @Route("/", name="order")
     */
    public function index(): Response
    {
        // Lấy ra toàn bộ orders
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
        // Tạo đối tượng order để đẩy vào form
        $order = new Order();
        // Tạo form
        $form = $this->createForm(OrderType::class, $order);
        // Xử lý request
        $form->handleRequest($request);
        // Kiểm tra form đã submit và đã valid chưa
        if ($form->isSubmitted() && $form->isValid()) {
            // Đẩy order vào database
            // Khởi tạo đối tượng manager để quản lý entity
            $manager = $this->getDoctrine()->getManager();
            // Set các data không cho người dùng nhập
            // Set lại timezone
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $order->setCreateAt(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', time())));
            $security = unserialize($request->getSession()->get("_security_main"));
            $order->setCreateBy($security->getUser()->getUserFullName());
            // Add vào trong context của symfony (Chưa thêm vào database)
            $manager->persist($order);
            // Flush gọi sẽ thêm order vào database bằng cách tự tạo 1 SQL transaction và thực hiện tự động
            $manager->flush();
            // Thông báo
            $this->addFlash('success', 'Create order success. Now you can add product to order.');
            // Điều hướng tới trang hiển thị của order
            return $this->redirectToRoute('add_order_detail', [
                'add_more' => true,
                'id' => $order->getId()
            ], Response::HTTP_SEE_OTHER);
        }
        // Nếu chưa thì điều hướng tới page add.html.twig
        // Tức là khi ấn vào button add symfony sẽ gọi hàm này nhưng tất nhiên form chưa submit
        // Nên nó sẽ chuyển thẳng tới cái block này để điều hướng tới trang add
        // Và khi ấn button "Add" thì symfony vẫn gọi hàm này nhưng khi đó form đã submit (và có thể đã valid)
        // Khi đó mới add order vào database
        // Luồng của nó sẽ là: Click button "Add" -> gọi hàm Add -> render form để người dùng nhập và submit -> gọi hàm add
        // lần 2 -> add vào database
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
        // Xử lý request
        $form->handleRequest($request);
        // Kiểm tra form đã submit và valid chưa
        if ($form->isSubmitted() && $form->isValid()) {
            // Đẩy order vào database
            // Khởi tạo đối tượng manager để quản lý entity
            $manager = $this->getDoctrine()->getManager();
            // Set các data không cho người dùng nhập
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $order->setUpdateAt(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', time())));
            $security = unserialize($request->getSession()->get("_security_main"));
            $order->setUpdateBy($security->getUser()->getUserFullName());
            // Add vào trong context của symfony (Chưa thêm vào database)
            $manager->persist($order);
            // Flush gọi sẽ thêm order vào database bằng cách tự tạo 1 SQL transaction và thực hiện tự động
            $manager->flush();
            // Thông báo
            $this->addFlash('success', 'Update order success!!');
            // Điều hướng tới trang hiển thị của order
            return $this->redirectToRoute('order', [], Response::HTTP_SEE_OTHER);
        }
        // Tương tự hàm add nhưng sẽ đẩy thêm đối tượng order
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
        // Tìm kiếm đối tượng
        $order = $this->getDoctrine()->getRepository(Order::class)->find($id);
        // Kiểm tra đối tượng có tồn tại hay không
        if ($order == null)
        {
            // Nếu không thì chỉ thông báo
            $this->addFlash('error', 'Order does not exist');
        }
        else
        {
            // Nếu có:
            // Khởi tạo đối tượng manager để quản lý entity
            $manager = $this->getDoctrine()->getManager();
            // Remove nó ra khỏi context
            $manager->remove($order);
            // Truy vấn database
            $manager->flush();
            // Thông báo
            $this->addFlash('success', 'Delete order success');
        }
        // Điều hướng tới trang index
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
}
