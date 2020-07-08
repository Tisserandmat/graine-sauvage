<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/admin", name="admin_")
*@IsGranted("ROLE_ADMIN")
*/
class AdminController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('_layoutAdmin.html.twig');
    }
}
