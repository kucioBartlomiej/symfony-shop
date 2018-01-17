<?php

namespace AppBundle\Cart;

use AppBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartManager {
    
    private $session;
    
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }


    public function checkCart(): Cart
    {
        ($this->session->get('cart') == null) ? $this->createCart() : null;
        return $this->session->get('cart');
    }


    public function clearCart()
    {
        ($this->session->get('cart') !== null) ? $this->session->remove('cart') : null;
        $this->checkCart();
    }


    private function createCart()
    {
        $this->session->set('cart', new Cart());
    }


    public function updateCart(Cart $cart)
    {
        $this->session->set('cart', $cart);
    }


    public function addToCart(CartProduct $cartProduct)
    {
        $cart = $this->checkCart();

        if ($cart->getProducts()->get($cartProduct->getId()))
        {
            $cart->increaseProductQuantity($cartProduct);
        }
        else
        {
            $cart->addNewProduct($cartProduct);
        }

        $this->updateCart($cart);
    }


    public function removeFromCart(Product $product)
    {
        $cart = $this->checkCart();
        
        if ($cart->getProducts()->get($product->getId()))
        {
            $cart->removeProduct($product->getId());
            $this->updateCart($cart);  
        }
    }


    public function updateProductQuantity(array $productData){
        
        $cart = $this->checkCart();
        
        if ($cart->getProducts()->get($productData['productId']))
        {
            $cart->updateProductQuantity($productData);
        }        
        
        $this->updateCart($cart);
    }


    public function getUpdatedProductData(int $id): array
    {
        $cart = $this->checkCart();
        
        $cartProduct = $cart->getProducts()->get($id);
        
        return $productData = [
            'productTotalPrice' => $cartProduct->getTotalPrice()
        ];
    }


    public function getUpdatedCartData(): array
    {
        $cart = $this->checkCart();
        
        return $cartData = [
            'subTotalPrice' => $cart->getSubTotalPrice(),
            'deliveryPrice' => $cart->getDeliveryPrice(),
            'totalPrice' => $cart->getTotalPrice()
        ];
    }
}
