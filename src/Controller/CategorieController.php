<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Penalite;
use App\Entity\Utilisateur;
use App\Form\CategorieType;
use App\Form\PenaliteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie", name="categorie")
     */
    public function index(): Response
    {
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }
    /**
     * @return Response
     * @Route("/AfficheCategorie",name="AfficheCategorie")
     */

    public function AfficheCategorie()
    {
        $repo = $this->getDoctrine()->getRepository(Categorie::class);
        $categorie = $repo->findAll();
        return $this->render('Admin/utilisateur/Affiche.html.twig', ['Categorie' => $categorie]);
    }

    /**
     * @Route("/ajouterCategorie", name="categorie")
     */
    function add(Request $request)
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->add('Ajouter', SubmitType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();

            return $this->redirectToRoute("AffichePenalites");
        }
        return $this->render('Arbitre/penalite/Ajouter.html.twig',['form' => $form->createView()]);

    }




    /**
     * @Route("/SuppCategorie/{id}",name="deletecategorie")
     */
    function Delete($id){
        $repo=$this->getDoctrine()->getRepository(Categorie::class);
        $categorie=$repo->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove( $categorie);
        $em->flush();
        return $this->redirectToRoute('AfficheCategorie');


    }

    /**
     * @Route("/updateCategorie/{id}",name="updateCategorie")
     */
    function upCategorie($id,Request $request){
        $repo=$this->getDoctrine()->getRepository(Categorie::class);
        $categorie=$repo->find($id);
        $form=$this->createForm(CategorieType::class,$categorie);
        $form->add('update',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('AfficheCategorie');
        }
        return $this->render('front/Equipe/Update.html.twig',[
            'fequipe'=>$form->createView()
        ]);

    }




















    //************************************** MOBILE *********************************
    /**
     * @Route("/allCategorie", name="allCategorie")
     */
    public function AllCategorie(NormalizerInterface $Normalizer)
    {
        $repository =$this->getDoctrine()->getRepository(Categorie::class);
        $categorie=$repository->findAll();

        $jsonContent=$Normalizer->normalize($categorie, 'json',['groups'=>'post:read']);
        //return $this->render('')
        return new Response(json_encode($jsonContent));

    }
    /**
     * @Route("/Categorie/{id}", name="Categorie")

     */
    public function CategorieId(Request $request,$id,NormalizerInterface $Normalizer)
    {
        $em=$this->getDoctrine()->getManager();
        $categorie= $em->getRepository(Categorie::class)->find($id);
        $jsonContent=$Normalizer->normalize($categorie, 'json',['groups'=>'post:read']);
        return new Response(json_encode($jsonContent));

    }

    /**
     * @Route("/AddCategorie/{designation}", name="AddCategorie")
     */

    public function AddCategorie(Request $request,NormalizerInterface $Normalizer,$designation)
    {
        $em = $this->getDoctrine()->getManager();
        $categorie = new Categorie();

        $categorie->setDesignation($designation);

        $em->persist($categorie);
        $em->flush();
        $jsonContent = $Normalizer->normalize($categorie, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/UpCategorie/{id}", name="CategorieUp")
     */

    public function UpdateCategorie(Request $request,NormalizerInterface $Normalizer,$id){
        $em=$this->getDoctrine()->getManager();
        $categorie= $em->getRepository(Categorie::class)->find($id);
        $categorie->setNsc($request->get('nsc'));
        $categorie->SetDesignation($request->get('designation'));
        $em->flush();
        $jsonContent=$Normalizer->normalize($categorie,'json',['groups'=>'post:read']);
        return new Response("information updated successfully".json_encode($jsonContent));

    }


    /**
     * @Route("/SuppCategorie/{id}", name="CategorieSupp")
     */
    public function SuppCategorie(Request $request,NormalizerInterface $Normalizer,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $categorie= $em->getRepository(Categorie::class)->find($id);
        $em->remove($categorie);
        $em->flush();
        $jsonContent=$Normalizer->normalize($categorie,'json',['groups'=>'post:read']);
        return new Response("Categorie supprimé".json_encode($jsonContent));

    }



}
