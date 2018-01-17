<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Product;
use AppBundle\Form\ProductAdminFilterType;
use AppBundle\Form\ProductCreateType;
use AppBundle\Form\ProductEditType;
use AppBundle\Product\ProductHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @Route("/product")
 */
class ProductController extends Controller {
    
    
    /**
     * @Route("/list/{page}", name="admin_product_list", requirements={"page"="\d+"}, defaults={"page"=1})
     * @Method("GET")
     */
    public function listAction(Request $request, int $page)
    {
        $formParams = [
            'nameLike' => $request->query->get('nameLike'),
            'category' => $request->query->get('category'),
            'status' => $request->query->get('status'),
            'perPage' => $request->query->get('perPage', $this->container->getParameter('pagination_limit'))
        ];
        
        $form = $this->createForm(ProductAdminFilterType::class, null, [
            'method' => 'GET',
            'params' => $formParams,
            'em' => $this->get('doctrine.orm.entity_manager')
        ]);
        
        $products = $this->getDoctrine()->getRepository('AppBundle:Product')->getAdminProductsList($formParams);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($products, $page, $formParams['perPage']);
        
        return $this->render('Admin/Product/list.html.twig', [
            'pagination' => $pagination,
            'form' => $form->createView()
        ]);
    }
    
    /**
     * @Route("/create", name="admin_product_create")
     * @Method("GET|POST")
     */
    public function createAction(Request $request)
    {
        $product = new Product();

        $form = $this->createForm(ProductCreateType::class, $product, [
            'validation_groups' => ['CreateProduct']
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->get(ProductHandler::class)->handleCreate($product);

            $this->addFlash('success', 'Product Created');

            return $this->redirectToRoute('admin_product_list');
        }

        return $this->render('Admin/Product/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

     /**
     * @Route("/edit/{id}", name="admin_product_edit")
     * @Method("GET|POST")
     */
    public function editAction(Request $request, Product $product)
    {
        $form = $this->createForm(ProductEditType::class, $product, [
            'validation_groups' => ['EditProduct']
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->get(ProductHandler::class)->handleUpdate($product);

            $this->addFlash('success', 'Product Edited');

            return $this->redirectToRoute('admin_product_show', [
                'id' => $product->getId()
            ]);
        }

        return $this->render('Admin/Product/edit.html.twig', [
            'form' => $form->createView(),
            'product' => $product,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_product_delete")
     * @Method("GET")
     */
    public function deleteAction(Product $product)
    {
        $this->get(ProductHandler::class)->handleRemove($product);

        $this->addFlash('success', "Product Deleted");

        return $this->redirectToRoute('admin_product_list');
    }


    /**
     * @Route("/show/{id}", name="admin_product_show")
     * @Method("GET")
     */
    public function showSingleAction(Product $product)
    {
        return $this->render('Admin/Product/show.html.twig', [
            'product' => $product
        ]);
    }
    
}
