<?php

namespace App\Controller;

use App\Entity\Penalite;
use App\Entity\PenaliteJoueur;
use App\Entity\Utilisateur;
use App\Form\PenaliteJoueurType;
use App\Repository\PenaliteJoueurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


class PenaliteJoueurController extends AbstractController
{
    /**
     * @Route("/penaliteJoueur", name="penaliteJoueur")
     */
    public function index(): Response
    {
        return $this->render('penaliteJoueur/index.html.twig', [
            'controller_name' => 'PenaliteJoueurController',
        ]);
    }

    /**
     * @Route("/penaliteJoueur/add", name="penaliteJoueur")
     */
    function add(Request $request)
    {
        $penaliteJoueur = new PenaliteJoueur();
        $form = $this->createForm(PenaliteJoueurType::class, $penaliteJoueur);

        $form->add('Ajouter', SubmitType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em=$this->getDoctrine()->getManager();
            $em->persist($penaliteJoueur);
            $em->flush();

            return $this->redirectToRoute("AffichePenaliteJoueur");
        }
        return $this->render('Arbitre/PenaliteJoueur/Ajouter.html.twig',['form' => $form->createView()]);

    }

    /**
     * @param PenaliteJoueurRepository $repository
     * @return Response
     * @Route ("/AffichePenaliteJoueur/", name="AffichePenaliteJoueur")
     */
    public function Affiche(){
        $em = $this->getDoctrine()->getManager();
        $penaliteJoueur = $em->getRepository(PenaliteJoueur::class)->findAll();
        return $this->render('Arbitre/penaliteJoueur/listePenalitesJoueur.html.twig', ['penaliteJoueur' => $penaliteJoueur]);
    }
    /**
     * @Route("penaliteJoueur/update/{id}", name="updatePenaliteJoueur" )
     */

    function Update(PenaliteJoueurRepository  $repository,Request $request, $id){
        $penaliteJoueur = $repository->find($id);
        $form = $this->createForm(PenaliteJoueurType::class, $penaliteJoueur);
        $form->add('Modifier', SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em=$this->getDoctrine()->getManager();
            $em->flush();

            $this -> addFlash('success', 'Penalité Joueur bien modifiée avec succès');

            return $this->redirectToRoute("AffichePenaliteJoueur");
        }
        return $this->render('Arbitre/penaliteJoueur/Update.html.twig',['form' => $form->createView()]);
    }


    /**
     * @Route("/penaliteJoueur/supp/{id}", name="dpj", methods="delete")
     */
    function delete($id, PenaliteJoueur $penaliteJoueur, Request $request)
    {



        $em = $this->getDoctrine()->getManager();
        $em->remove($penaliteJoueur);
        $em->flush();

        $this->addFlash('danger', 'Penalité Joueur bien supprimée avec succès');


        return $this->redirectToRoute("AffichePenaliteJoueur");
    }


    /**

     * @Route("/AllPenaliteJoueur",name="AllPenaliteJoueur")
     */
    function AllPenaliteJoueur(NormalizerInterface $normalizer)
    {
        $repository=$this->getDoctrine()->getRepository(PenaliteJoueur::class);
        $penaliteJoueur = $repository->findAll();
        $jsonContent = $normalizer->normalize($penaliteJoueur, 'json', ['groups' => 'PenaliteJoueur']);
        return new Response(json_encode($jsonContent));

        return $this->render('Arbitre/PenaliteJoueur/listePenalitesJoueur.html.twig', ['penalites' => $penalite]);


    }


    /**

     * @Route("/PenaliteJoueurId/{id}",name="PenaliteJoueurId")
     */
    function penaliteJoueurID (Request $request,$id,NormalizerInterface $normalizer){

        $em=$this->getDoctrine()->getManager();

        $penaliteJoueur = $em->getRepository(PenaliteJoueur::class)->find($id);
        $jsonContent = $normalizer->normalize($penaliteJoueur, 'json', ['groups' => 'PenaliteJoueur']);
        return new Response(json_encode($jsonContent));
    }


    /**
     * @Route ("/AddPenaliteJoueur/{heure}/{minute}/{joueur}/{penalite}", name ="AddPenaliteJoueur")
     */
    public function AddPenaliteJoueur(Request $request, NormalizerInterface $normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $punition = new PenaliteJoueur();
        $user = $em->getRepository(Utilisateur::class)->find($request->get('joueur'));
        $penalite = $em->getRepository(Penalite::class)->find($request->get('penalite'));
        //$date = \DateTime::createFromFormat('Ymd', $request->get('dat'));
        $punition->setJoueur($user);
        $punition->setPenalite($penalite);
        //$heure = \DateTime::createFromFormat('Hmi', $request->get('heure'));
        $heure = new \DateTime();

        $h1 =$request->get('heure');
        $minute = $request->get('minute');
        $heure->setTime($h1,$minute,00);

        $punition->setHeure($heure);



        $em->persist($punition);
        $em->flush();

        $jsonContent = $normalizer->normalize($punition, 'json', ['groups'=>'PenaliteJoueur']);
        return new Response(json_encode($jsonContent));
    }


    /**
     * @Route("/UpdatePenaliteJoueur/{id}",name="UpdatePenaliteJoueur")
     */
    function UpdatePenaliteJoueur (Request $request, $id, NormalizerInterface $normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $penaliteJoueur = $em->getRepository(Penalite::class)->find($id);
        $penaliteJoueur->setHeure($request->get('heure'));
        $penaliteJoueur->setArbitre($request->get('arbitre'));
        $penaliteJoueur->setJoueur($request->get('joueur'));
        $penaliteJoueur->setMatche($request->get('matche'));
        $penaliteJoueur->setPenalite($request->get('penalite'));


        $em->flush();
        $jsonContent = $normalizer->normalize($penaliteJoueur, 'json', ['groups' => 'PenaliteJoueur']);
        return new Response("Updated successfully" . json_encode($jsonContent));


    }

    /**
     * @Route("/DeletePenaliteJoueur/{id}",name="DeletePenaliteJoueur")
     */
    function DeletePenaliteJoueur (Request $request, $id, PenaliteJoueur $penaliteJoueur, NormalizerInterface $normalizer)
    {

        $em = $this->getDoctrine()->getManager();
        $penaliteJoueur = $em->getRepository(PenaliteJoueur::class)->find($id);
        $em->remove($penaliteJoueur);

        $em->flush();
        $jsonContent = $normalizer->normalize($penaliteJoueur, 'json', ['groups' => 'PenaliteJoueur']);
        return new Response("Deleted successfully" . json_encode($jsonContent));

    }




   /* /**
     * @Route("/searchPenaliteJoueur ", name="searchPenaliteJoueur")
     */
 /*   public function searchPenaliteJoueur(Request $request,NormalizerInterface $Normalizer){
$repository = $this->getDoctrine()->getRepository(PenaliteJoueur::class);
$requestString=$request->get('searchValue');
$penaliteJoueur= $repository->findPenaliteJoueurByNsc($requestString);
$jsonContent = $Normalizer->normalize($penaliteJoueur, 'json',['groups'=>'searchPenaliteJ']);
$retour=json_encode($jsonContent);
return new Response($retour);
}
 */





    /**
     * @Route("/PlanPenalite", name="PlanPenalite")
     */
    public function PlanPenalite(): Response
    {  $repo=$this->getDoctrine()->getRepository(PenaliteJoueur::class);
        $penaliteJoueur=$repo->findAll();
        $rdv=[];
        foreach ($penaliteJoueur as $p){
            $rdv []=[
                'id'=>$p->getId(),
                'start'=>$p->getHeure()->format('Y-m-d H:i:s'),
                //'end'=>$p->getHeure()->format('Y-m-d H:i:s'),
                'title'=>$p->getJoueur(),


            ];

        }
        $data= json_encode($rdv);
        return $this->render('Arbitre/PenaliteJoueur/calander.html.twig',compact('data'));
    }



    /*
     /**
         * @Route("/searchPenalite ", name="searchPenalites")
         */

    /* public function searchPenalite(Request $request,NormalizerInterface $Penalite)
     {
         $repository = $this->getDoctrine()->getRepository(Penalite::class);
         $requestString=$request->get('searchValue');
         $Penalite = $repository->findPenaliteByNsc($requestString);
         $jsonContent = $Normalizer->normalize(Penalite, 'json',['groups'=>'Penalites:read']);
         $retour=json_encode($jsonContent);
         return new Response($retour);

     }
  */


    /**
     * @Route("/pdf", name="pdf")
     */
    public function Affichep(PenaliteJoueurRepository $repository){

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $penalitesJoueurs = $repository->findAll();


        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('Arbitre/PenaliteJoueur/pdf.html.twig', ['penalitesJoueurs' => $penalitesJoueurs]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
        return $this->render('home');

    }



}
