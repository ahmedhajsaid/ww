<?php

namespace App\Controller;

use App\Entity\Penalite;
use App\Form\PenaliteType;
use App\Repository\PenaliteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use Symfony\Component\Routing\Annotation\Route;




class PenaliteController extends AbstractController
{
/**
*@Route("/",name="article_list")
*/
    public function home(Request$request ,  PenaliteRepository $PenaliteRepository)
    {
        /*$propertySearch = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class, $propertySearch);
        $form->handleRequest($request);
        $articles = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $nom = $propertySearch->getNom();
            if ($nom != "")


                $articles = $this->getDoctrine()->getRepository(Article::class)->findBy(['nom' => $nom]);
            else
                //sisiaucunnom n'estfournionaffichetouslesarticles
                $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();
        */
        $requestString =$request->get('searchValue');
        $triString =$request->get('triBy');
        if($requestString !=null)
            $penalite= $PenaliteRepository ->trouverRegimeParID($requestString);
        elseif($triString  !=null)
            $penaliteJoueur= $PenaliteRepository->findBy([],[$triString=>'ASC']);
        else
            return
                $penalite= $PenaliteRepository->findAll();


                return $this->render('penalite/index.html.twig', ['controller_name' => 'PenaliteController',]);

    }

    /**
     * @Route("/penalite/add", name="penalite")
     */
    function add(Request $request )
    {
        $penalite = new Penalite();
        $form = $this->createForm(PenaliteType::class, $penalite);
        $form->add('Ajouter', SubmitType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($penalite);
            $em->flush();

            return $this->redirectToRoute("AffichePenalites");
        }
        return $this->render('Arbitre/penalite/Ajouter.html.twig',['form' => $form->createView()]);

    }

    /**
     * @param PenaliteRepository $repository
     * @return Response
     * @Route ("/AffichePenalite/", name="AffichePenalites")
     */
    public function Affiche (PenaliteRepository  $repository){
        $penalite = $repository->findAll();

        return $this->render('Arbitre/penalite/listePenalites.html.twig', ['penalites' => $penalite]);
    }

    /**
     * @Route("penalite/update/{id}", name="UpdatePenalite" )
     */

    function Update(PenaliteRepository $repository,Request $request, $id){
        $penalite = $repository->find($id);
        $form = $this->createForm(PenaliteType::class, $penalite);
        $form->add('Modifier', SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em=$this->getDoctrine()->getManager();
            $em->flush();

            $this -> addFlash('success', 'Penalité bien modifiée avec succès');

            return $this->redirectToRoute("AffichePenalites");
        }
        return $this->render('Arbitre/penalite/Update.html.twig',['form' => $form->createView()]);
    }


    /**
     * @Route("/penalite/supp/{id}", name="dp", methods="DELETE")
     */
    function delete($id, Penalite $penalite, Request $request)
    {



        $em = $this->getDoctrine()->getManager();
        $em->remove($penalite);
        $em->flush();

        $this->addFlash('danger', 'Penalité bien supprimée avec succès');


        return $this->redirectToRoute("AffichePenalites");
    }

    /**

     * @Route("/AllPenalite",name="AllPenalite")
     */
    function AllPenalite(NormalizerInterface $normalizer)
    {
        $repository=$this->getDoctrine()->getRepository(Penalite::class);
        $penalite = $repository->findAll();
        $jsonContent = $normalizer->normalize($penalite, 'json', ['groups' => 'Penalite']);
        return new Response(json_encode($jsonContent));

        return $this->render('Arbitre/penalite/listePenalites.html.twig', ['penalites' => $penalite]);


    }


    /**

     * @Route("/PenaliteId/{id}",name="PenaliteId")
     */
    function penaliteID (Request $request,$id,NormalizerInterface $normalizer){

        $em=$this->getDoctrine()->getManager();

        $penalite = $em->getRepository(Penalite::class)->find($id);
        $jsonContent = $normalizer->normalize($penalite, 'json', ['groups' => 'Penalite']);
        return new Response(json_encode($jsonContent));
    }


    /**
     * @Route("/AddPenalite",name="AddPenalite")
     */
    function AddPenalite(Request $request, NormalizerInterface $normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $penalite = new Penalite();
        $penalite->setDesignation($request->get('designation'));
        $penalite->setNbrePointsRetires($request->get('nbrePointsRetires'));
        $em->persist($penalite);
        $em->flush();
        $jsonContent = $normalizer->normalize($penalite, 'json', ['groups' => 'Penalite']);
        return new Response(json_encode($jsonContent));


    }

    /**
     * @Route("/UpdatePenalite/{id}",name="UpdatePenaliteJson")
     */
    function UpdatePenalite (Request $request, $id, NormalizerInterface $normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $penalite = $em->getRepository(Penalite::class)->find($id);
        $penalite->setDesignation($request->get('designation'));
        $penalite->setNbrePointsRetires($request->get('nbrePointsRetires'));
        $em->flush();
        $jsonContent = $normalizer->normalize($penalite, 'json', ['groups' => 'Penalite']);
        return new Response("Updated successfully" . json_encode($jsonContent));


    }
    /**
     * @Route("/deletePenalite/{id}",name="deletePenalite")
     */
    function deletePenalite (Request $request, $id, Penalite $penalite, NormalizerInterface $normalizer)
    {

        $em = $this->getDoctrine()->getManager();
        $penalite = $em->getRepository(Penalite::class)->find($id);
        $em->remove($penalite);
        $em->flush();
        $jsonContent = $normalizer->normalize($penalite, 'json', ['groups' => 'Penalite']);
        return new Response("Deleted successfully" . json_encode($jsonContent));

    }




    /*
     /**
         * @Route("/searchPenalite ", name="searchPenalite")
         */

 /*  public function searchPenalite(Request $request,NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Penalite::class);
        $requestString=$request->get('searchValue');
        $Penalite = $repository->findPenaliteByNsc($requestString);
        $jsonContent = $Normalizer->normalize($Penalite, 'json',['groups'=>'Penalites:read']);
        $retour=json_encode($jsonContent);
        return new Response($retour);

    }
 **/
    /**
     * @Route("/searchTerrain ", name="searchTerrain")
     */
    public function searchTerrain(Request $request,NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Terrain::class);
        $designation=$request->get('searchValue');
        $terrains = $repository->findTerrainByDesignation($designation);
        $jsonContent = $Normalizer->normalize($terrains, 'json',['groups'=>'terrains']);
        $retour=json_encode($jsonContent);
        return new Response($retour);

    }




    /**
     * @Route("/searchPenalite ", name="searchPenalite")
     */
    public function searchPenalite(Request $request,NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Penalite::class);
        $designation=$request->get('searchValue');
        $penalite = $repository->findPenaliteByDesignation($designation);
        $jsonContent = $Normalizer->normalize($penalite, 'json',['groups'=>'Searchpenalite']);
        $retour=json_encode($jsonContent);
        return new Response($retour);

    }





    /**
     * @Route("/recherche ", name="recherche")
     */
    public function recherche(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $penalite = $em->getRepository(Penalite::class)->findAll();
        if($request->isMethod("post"))
        {
            $term = $request->get('search');
            $penalite = $em->getRepository(Penalite::class)->findPenaliteByDesignation($term);
        }
        return $this->render('Arbitre/penalite/listePenalites.html.twig', [
            'designation' => $penalite,
        ]);

    }









}
