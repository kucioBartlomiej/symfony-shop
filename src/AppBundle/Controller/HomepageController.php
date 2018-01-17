<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class HomepageController extends Controller
{
    
    /**
     * @Route("/", name="homepage")
     * @Method("GET")
     */
    public function homepageAction()
    {
        return $this->render('Homepage/homepage.html.twig');
    }
    
}
