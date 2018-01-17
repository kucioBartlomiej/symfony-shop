<?php

namespace AppBundle\Controller;

use AppBundle\Cart\CartManager;
use AppBundle\Form\OrderCheckoutType;
use AppBundle\Order\OrderAfterCompleteRedirections;
use AppBundle\Order\OrderFactory;
use AppBundle\Order\OrderHandler;
use AppBundle\Order\OrderUserInjector;
use AppBundle\Order\OrderValidationGroups;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
* 
* @Route("/order")
* 
*/
class OrderController extends Controller {

    /**
    * @Route("/checkout", name="order_checkout")
    * @Method("GET|POST")
    */
    public function checkoutAction(Request $request)
    {
        $cart = $this->get(CartManager::class)->checkCart();

        if ($cart->productsCount() < 1) {
            return $this->redirectToRoute('cart_show');
        }

        $order = $this->get(OrderFactory::class)->createFromCart($cart);

        if ($this->getUser())
        {
            $order = OrderUserInjector::injectUser($order, $this->getUser());
        }

        $form = $this->createForm(OrderCheckoutType::class, $order, [
            'validation_groups' => OrderValidationGroups::getGroups($request, $cart)
        ]);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $this->get(OrderHandler::class)->handleCreate($order);

            $this->get(CartManager::class)->clearCart();

            return $this->redirectToRoute(OrderAfterCompleteRedirections::getRedirection($order));
        }
        
        return $this->render('Order/checkout.html.twig', [
            'form' => $form->createView(),
            'order' => $order,
        ]);
    }

    /**
     * @Route("/payment", name="order_payment")
     * @Method("GET")
     */
    public function paymentAction()
    {
        return new Response("Payment");
    }

    /**
     * @Route("/order-information", name="order_information")
     * @Method("GET")
     */
    public function orderInformationAction()
    {
        return new Response("ORDER DONE");
    }
}
