<?php


namespace AppBundle\Controller\Admin;

use AppBundle\Category\CategoryHandler;
use AppBundle\Entity\Category;
use AppBundle\Form\CategoryManageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;


/**
 * @Route("/category")
 */
class CategoryController extends Controller
{

    /**
     * @Route("/list", name="admin_category_list")
     * @Method("GET")
     */
    public function listAction()
    {
        $categories = $this->getDoctrine()->getRepository('AppBundle:Category')->getMainCategories();

        return $this->render('Admin/Category/list.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/create/{id}", name="admin_category_create", defaults={"id" = null})
     * @Method("GET|POST")
     */
    public function createAction(Request $request, Category $parentCategory = null)
    {
        $category = new Category($parentCategory);

        $form = $this->createForm(CategoryManageType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->get(CategoryHandler::class)->handleCreate($category);

            $this->addFlash('success', 'Category Created');

            return $this->redirectToRoute('admin_category_list');
        }

        return $this->render('Admin/Category/manage.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/{id}", name="admin_category_edit")
     * @Method("GET|POST")
     */
    public function editAction(Request $request, Category $category)
    {
        $form = $this->createForm(CategoryManageType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->get(CategoryHandler::class)->handleUpdate($category);

            $this->addFlash('success', 'Category Edited!');

            return $this->redirectToRoute('admin_category_list');
        }

        return $this->render('Admin/Category/manage.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_category_delete")
     * @Method("GET")
     */
    public function deleteAction(Category $category)
    {
        if (count($category->getProducts()) > 0)
        {
            $this->addFlash('error', 'This category can not be removed because has signed products!');

            return $this->redirectToRoute('admin_category_edit', ['id' => $category->getId()]);
        }

        if (count($category->getChildren()) > 0)
        {
            $this->addFlash('error', 'This category can not be removed because has signed subcategories!');

            return $this->redirectToRoute('admin_category_edit', ['id' => $category->getId()]);
        }

        $this->get(CategoryHandler::class)->handleRemove($category);

        $this->addFlash('success', 'Category Deleted!');

        return $this->redirectToRoute('admin_category_list');
    }

}