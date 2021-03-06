<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontOfficeController extends AbstractController
{
    /**
     * @Route("/front/office", name="front_office")
     */
    public function index(): Response
    {
        return $this->render('front_office/index.html.twig', [
            'controller_name' => 'FrontOfficeController',
        ]);
    }

    /**
     * @Route("/terrains", name="front_office")
     */
    public function terrains(): Response
    {
        return $this->render('front_office/terrainsList.html.twig', [
            'controller_name' => 'FrontOfficeController',
        ]);
    }
}
