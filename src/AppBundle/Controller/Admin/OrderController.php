<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Form\OrderChangeStatusType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Order;
use AppBundle\Form\OrderAdminFilterType;
use AppBundle\Form\OrderChangeStatus;

/**
 * @Route("/order")
 */
class OrderController extends Controller {
    
    /**
     * @Route("/list/{page}", name="admin_order_list", requirements={"page"="\d+"}, defaults={"page"=1})
     * @Method("GET")
     */
    public function listAction(Request $request, int $page)
    {
        $formParams = [
            'orderId' => $request->query->get('orderId'),
            'status' => $request->query->get('status'),
            'perPage' => $request->query->get('perPage', $this->container->getParameter('pagination_limit'))
        ];
        
        $form = $this->createForm(OrderAdminFilterType::class, null, [
            'method' => 'GET',
            'params' => $formParams,
        ]);
        
        $orders = $this->getDoctrine()->getRepository(Order::class)->getAdminOrderList($formParams);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($orders, $page, $formParams['perPage']);
        
        return $this->render('Admin/Order/list.html.twig', [
            'pagination' => $pagination,
            'form' => $form->createView()
        ]);
    }
    
    /**
     * @Route("/show/{id}", name="admin_order_show_single")
     * @Method("GET")
     */
    public function showSingleAction(Order $order)
    {
        return $this->render('Admin/Order/showSingle.html.twig', [
            'order' => $order
        ]);
    }
    
    /**
     * @Route("/change-status/{id}", name="admin_order_change_status")
     * @Method("GET|POST")
     */
    public function changeStatusAction(Request $request, Order $order)
    {
        $form = $this->createForm(OrderChangeStatusType::class, $order);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            
            $this->addFlash('success', 'Order Status Updated');
            
            return $this->redirectToRoute('admin_order_show_single', [
                'id' => $order->getId()
            ]);
        }
        
        return $this->render('Admin/Order/changeStatus.html.twig', [
            'order' => $order,
            'form' => $form->createView()
        ]);
    }
    
}
