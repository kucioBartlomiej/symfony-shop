<?php


namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Route("/dashboard")
 */
class DashboardController extends Controller
{
    /**
     * @Route("/", name="admin_dashboard")
     * @Method("GET")
     */
    public function dashboardAction()
    {
        return $this->render('Admin/Dashboard/dashboard.html.twig');
    }
}