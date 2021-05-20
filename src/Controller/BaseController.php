<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    /**
     * @Route("/aboutus", name="aboutus")
     */
    public function index(): Response
    {
        return $this->render('front/aboutus.html.twig');
    }

    /**
     * @Route("/arbitre", name="arbitre")
     */
    public function arbitre(): Response
    {
        return $this->render('arbitre/index.html.twig');
    }

    /**
     * @Route("/prop", name="prop")
     */
    public function prop(): Response
    {
        return $this->render('Prop/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }






}
