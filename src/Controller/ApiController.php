<?php

namespace App\Controller;

use App\Entity\Competition;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * @Route("/api", name="api")
     */
    public function index()
    {
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }

    /**
     * @Route("/api/{id}/updatecomp", name="api_event_edit", methods={"PUT"})
     */
    public function majEvent(?Competition $calendar, Request $request)
    {
        // On récupère les données
        $donnees = json_decode($request->getContent());

        if(
            isset($donnees->designation) && !empty($donnees->designation) &&
            isset($donnees->dateCreation) && !empty($donnees->dateCreation) &&
            isset($donnees->dateDebut) && !empty($donnees->dateDebut)

        ){
            // Les données sont complètes
            // On initialise un code
            $code = 200;

            // On vérifie si l'id existe
            if(!$calendar){
                // On instancie un rendez-vous
                $calendar = new Competition;

                // On change le code
                $code = 201;
            }

            // On hydrate l'objet avec les données
            $calendar->setDesignation($donnees->designation);

            $calendar->setDateCreation(new DateTime($donnees->dateCreation));

                $calendar->setDateDebut(new DateTime($donnees->dateDebut));


            $em = $this->getDoctrine()->getManager();
            $em->persist($calendar);
            $em->flush();

            // On retourne le code
            return new Response('Ok', $code);
        }else{
            // Les données sont incomplètes
            return new Response('Données incomplètes', 404);
        }


        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }
}