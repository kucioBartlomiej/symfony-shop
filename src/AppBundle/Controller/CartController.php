<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Cart\CartProduct;
use AppBundle\Cart\CartManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/cart")
 */
class CartController extends Controller {
    
    /**
     * @Route("/show", name="cart_show")
     * @Method("GET")
     */
    public function showAction(): Response
    {
        $cart = $this->get(CartManager::class)->checkCart();
        
        return $this->render('Cart/show.html.twig', [
            'cart' => $cart
        ]);
    }
    
    /**
     * @Route("/add/{id}", name="cart_add_product")
     * @Method("POST")
     */
    public function addProductAction(Request $request, Product $product)
    {
        $cartManager = $this->get(CartManager::class);

        $quantity = $request->request->get('quantity');
        
        $cartProduct = new CartProduct($product, $quantity);

        $cartManager->addToCart($cartProduct);
        
        $cartCount = [
            'cartCount' => $cartManager->checkCart()->productsCount()
        ];
        
        return new JsonResponse(json_encode($cartCount));
    }
    
    /**
     * @Route("/remove/{id}", name="cart_remove_product")
     * @Method("GET")
     */
    public function removeProductAction(Product $product)
    {
        $this->get(CartManager::class)->removeFromCart($product);
        
        $this->addFlash('success', 'Removed Form Cart');
        
        return $this->redirectToRoute('cart_show');
    }
    
    /**
     * @Route("/clear", name="cart_clear")
     * @Method("GET")
     */
    public function clearAction()
    {
        $this->get(CartManager::class)->clearCart();
        return $this->redirectToRoute('cart_show');
    }

    /**
     * @Route("/update-product-quantity", name="cart_update_product_quantity")
     * @Method("POST")
     */
    public function updateProductQuantityAction(Request $request)
    {
        $cartManager = $this->get(CartManager::class);

        $productData = [
            'productId' => $request->request->get('product'),
            'quantity' => $request->request->get('quantity'),
        ];

        $cartManager->updateProductQuantity($productData);
       
        $updatedProductData = $cartManager->getUpdatedProductData($productData['productId']);
        $updatedCartData = $cartManager->getUpdatedCartData();
        
        $updatedData = array_merge($updatedProductData, $updatedCartData);
        
        return new JsonResponse(json_encode($updatedData));
    }
    
}
