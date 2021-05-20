<?php

namespace App\Controller\Prop_complexe;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    /**
     * @Route("/Prop_complexe/profile", name="profile")
     */
    public function index(): Response
    {
        return $this->render('Admin/profil/profile.html.twig', [
            'controller_name' => 'ProfileController',
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
