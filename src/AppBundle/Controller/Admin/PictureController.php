<?php


namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Picture;
use AppBundle\Picture\PictureHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PictureController extends Controller
{

    /**
     * @Route("/delete-picture/{id}", name="admin_picture_delete")
     * @Method("GET")
     */
    public function deleteAction(Picture $picture)
    {
        $productId = $picture->getProduct()->getId();

        $this->get(PictureHandler::class)->deletePicture($picture);

        $this->addFlash('success', 'Picture Deleted');

        return $this->redirectToRoute('admin_product_edit', [
            'id' => $productId
        ]);

    }

}