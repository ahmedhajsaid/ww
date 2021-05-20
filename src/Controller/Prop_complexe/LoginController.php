<?php

namespace App\Controller\Prop_complexe;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    /**
     * @Route("/Porp/login", name="login")
     */
    public function index(): Response
    {
        return $this->render('admin/login/login.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }


}
