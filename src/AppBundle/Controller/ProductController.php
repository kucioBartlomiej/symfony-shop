<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Entity\Category;
use AppBundle\Form\ProductListType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/product")
 */
class ProductController extends Controller {
   
    /**
     * @Route("/list/{page}/{id}", name="product_list", requirements={"page"="\d+"}, defaults={"page"=1, "id"=null})
     * @Method("GET")
     */
    public function listAction(Request $request, int $page, Category $category = null)
    {
        $formParams = [
            'sortBy' => $request->query->get('sortBy'),
            'perPage' => $request->query->get('perPage', $this->container->getParameter('pagination_limit'))
        ];
        
        $form = $this->createForm(ProductListType::class, null, [
            'method' => 'GET',
            'params' => $formParams
        ]);
        
        $categoryGroup =  ($category !== null) ? $category->getCategorygroup()->getValues() : null;
       
        $products = $this->getDoctrine()->getRepository('AppBundle:Product')->searchByCategoryGroup($categoryGroup, $formParams);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($products, $page, $formParams['perPage']);
        
        return $this->render('Product/list.html.twig', [
            'pagination' => $pagination,
            'currentCategory' => $category,
            'form' => $form->createView()
        ]);
    }
    
     /**
     * @Route("/show/{id}", name="product_show_single")
     * @Method("GET")
     */
    public function showSingleAction(Product $product)
    {  
        return $this->render('Product/single.html.twig', [
            'product' => $product
        ]);
    }
    
}
