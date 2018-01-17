<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Product;
use AppBundle\Form\StockAdminFilterType;
use AppBundle\Entity\Stock;
use AppBundle\Form\StockUpdateType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/stock")
 */
class StockController extends Controller {
    
    /**
     * @Route("/list/{page}", name="admin_stock_list", requirements={"page"="\d+"}, defaults={"page"=1})
     * @Method("GET")
     */
    public function listAction(Request $request, int $page)
    {
        $formParams = [
            'nameLike' => $request->query->get('nameLike'),
            'orderByQuantity' => $request->query->get('orderByQuantity'),
            'perPage' => $request->query->get('perPage', $this->container->getParameter('pagination_limit'))
        ];
        
        $form = $this->createForm(StockAdminFilterType::class, null, [
            'method' => 'GET',
            'params' => $formParams,
        ]);
        
        $stocks = $this->getDoctrine()->getRepository(Stock::class)->getAdminStocks($formParams);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($stocks, $page, $formParams['perPage']);
        
        return $this->render('Admin/Stock/list.html.twig', [
            'pagination' => $pagination,
            'form' => $form->createView()
        ]);
    }
    
    /**
     * @Route("/update/{id}", name="admin_stock_update")
     * @Method("GET|POST")
     */
    public function updateAction(Request $request, Stock $stock)
    {
        $form = $this->createForm(StockUpdateType::class, $stock);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            
            $this->addFlash('success', 'Stock Updated');
            
            return $this->redirectToRoute('admin_product_show', [
                'id' => $stock->getProduct()->getId()
            ]);
        }
        
        return $this->render('Admin/Stock/update.html.twig', [
            'form' => $form->createView(),
            'stock' => $stock
        ]);
    }
    
}
