<?php

namespace AppBundle\Controller;

use AppBundle\Form\ProductListType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/search")
 */
class SearchController extends Controller {
    
    
    /**
     * @Route("/product/{page}", name="search_product", requirements={"page"="\d+"}, defaults={"page"=1})
     * @Method("GET")
     */
    public function searchProductsAction(Request $request, int $page)
    {  
       $searchString =  $request->query->get('search');
       
       $formParams = [
            'sortBy' => $request->query->get('sortBy'),
            'perPage' => $request->query->get('perPage', $this->container->getParameter('pagination_limit'))
        ];
        
        $form = $this->createForm(ProductListType::class, null, [
            'action' => $this->generateUrl('search_product'),
            'method' => 'GET',
            'params' => $formParams,
            'search' => $searchString
        ]);

        $products = $this->getDoctrine()->getRepository('AppBundle:Product')->searchByString($searchString, $formParams);
       
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($products, $page, $formParams['perPage']);
        
        return $this->render('Search/list.html.twig', [
            'pagination' => $pagination,
            'currentCategory' => null,
            'form' => $form->createView()
        ]);
    }
    
}
