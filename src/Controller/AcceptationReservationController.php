<?php

namespace App\Controller;

use App\Entity\AcceptationReservation;
use App\Entity\Reservation;
use App\Entity\Utilisateur;
use App\Repository\AcceptationReservationRepository;
use App\Repository\ReservationRepository;
use App\Repository\UtilisateurRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AcceptationReservationController extends AbstractController
{
    public function __construct()
    {

    }

    /**
     * @Route("/acceptation/reservation", name="acceptation_reservation")
     */
    public function index(): Response
    {
        return $this->render('acceptation_reservation/index.html.twig', [
            'controller_name' => 'AcceptationReservationController',
        ]);
    }

    /**
     * @Route("/acc/{id}", name="acceptation")
     */
    public function accepter(UtilisateurRepository $uRep,ReservationRepository $repository,AcceptationReservationRepository $acceptationReservationRepository, UtilisateurRepository $utilisateurRepository, $id)
    {
        if ($this->getUser()) {
            $utilisateur = $this->getUser();
            $reservation = $repository->find($id);
            $equipe = $utilisateurRepository->findBy(array('equipe' => $reservation->getClient()->getEquipe()));

            $acc = new AcceptationReservation();
            $acc->setClient($utilisateur);
            $acc->setReservation($reservation);
            $acc->setAcceptee(true);
            $em = $this->getDoctrine()->getManager();
            $em->persist($acc);
            $em->flush();
            $acceptations = $acceptationReservationRepository->findBy(array('reservation' => $id));
            // if(count($acceptations)==5)
            // {

            $reservation->setAcceptee(true);
            //$em->remove($reservation);
            $em->flush();
            //  }

            $reservations = $repository->findReservation($utilisateur->getEquipe()->getCapitain());
            return $this->redirectToRoute("reservation");
            return $this->render('front/reservation.html.twig', ['reservations' => $reservations]);
        }else{
            return $this->redirectToRoute('app_login');
        }
    }

    /**
     * @Route("/refus/{id}", name="refus")
     */
    public function refuser(ReservationRepository $repository, AcceptationReservationRepository $reservationRepository, $id)
    {
        if ($this->getUser()) {
        $repo=$this->getDoctrine()->getRepository(Utilisateur::class);
        $utilisateur = $this->getUser();
        $reservation = $repository->find($id);
        $acc = new AcceptationReservation();
        $acc->setReservation($reservation);
        $acc->setAcceptee(false);
        $em=$this->getDoctrine()->getManager();
        $em->persist($acc);
        $em->flush();
        return $this->render('acceptation_reservation/index.html.twig', [
            'controller_name' => 'AcceptationReservationController',
        ]);
    }else{
return $this->redirectToRoute('app_login');
}
    }


    /**
     * @Route("/invitation/{id}", name="invit")
     */

    public function show($id, UtilisateurRepository $uRep, ReservationRepository $reservationRepository)
    {
        $utilisateur = $uRep->find(31);
        $reservation = $reservationRepository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->persist($reservation);
        $em->flush();
        //$this -> addFlash('success', 'Terrain bien ajouté avec succès');
        //return $this->redirectToRoute("/reservation");



        return $this->render('front/reservation/invitation.html.twig', [
            'reservation'=> $reservation,
        ]);

    }



}
