<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Order;
use AppBundle\Form\UserDeliveryInformationType;
use AppBundle\User\UserHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @Route("/account")
 */
class AccountController extends Controller {
   
    /**
     * @Route("/", name="account_index")
     * @Method("GET")
     */
    public function dashboardAction()
    {
        return $this->render('Account/dashboard.html.twig', [
            'user' => $this->getUser()
        ]);
    }
    
    /**
     * @Route("/orders", name="account_order_list")
     * @Method("GET")
     */
    public function showOrdersListAction()
    {
        return $this->render('Account/orderList.html.twig', [
            'orders' => $this->getUser()->getOrders()
        ]);
    }
    
    /**
     * @Route("/order/{id}", name="account_single_order")
     * @Method("GET")
     */
    public function showSingleOrderAction(Order $order)
    {
        if ($order->getUser() == $this->getUser())
        {
            return $this->render('Account/singleOrder.html.twig', [
                'order' => $order
            ]);
        }
        throw new AccessDeniedException();
    }

    /**
     * @Route("/delivery-data", name="account_delivery_data")
     * @Method("GET|POST")
     */
    public function updateDeliveryInformationAction(Request $request)
    {
        $user = $this->getUser();

        $form = $this->createForm(UserDeliveryInformationType::class, $user, [
            'validation_groups' => ['userInformationUpdate']
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->get(UserHandler::class)->handleUpdate($user);

            return $this->redirectToRoute('account_index');
        }

        return $this->render('Account/updateDeliveryInformation.html.twig', [
            'form' => $form->createView()
        ]);

    }

}
