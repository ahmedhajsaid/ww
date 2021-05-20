<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(): Response
    {
        return $this->render('front/index.php');
    }
    /**
     * @Route("/reservation", name="reservation")
     */
    public function reservation(): Response
    {
        return $this->render('front/reservation.html.twig');
    }
    /**
     * @Route("/shop", name="shop")
     */
    public function shop(): Response
    {
        return $this->render('front/shop.html.twig');
    }
}
