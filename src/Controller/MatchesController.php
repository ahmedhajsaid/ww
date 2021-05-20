<?php

namespace App\Controller;

use App\Entity\Invitation;
use App\Entity\Matche;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class MatchesController extends AbstractController
{
    /**
     * @Route("/matches", name="matches")
     */
    public function index(): Response
    {
        return $this->render('matches/index.html.twig', [
            'controller_name' => 'MatchesController',
        ]);
    }
    /**

     * @Route("/AllMatche",name="AllMatche")
     */
    function AllMatche(NormalizerInterface $normalizer){
        $repo=$this->getDoctrine()->getRepository(Matche::class);
        $Equipe=$repo->findAll();
        $jsonContent=$normalizer->normalize($Equipe,'json',['groups'=>'Matche']);
        return new Response(json_encode($jsonContent));


    }
    /**

     * @Route("/MatcheId/{id}",name="MatcheId")
     */
    function MatcheId(Request $request,$id,NormalizerInterface $normalizer){
        $em=$this->getDoctrine()->getManager();

        $Equipe=$em->getRepository(Matche::class)->find($id);
        $jsonContent=$normalizer->normalize($Equipe,'json',['groups'=>'Matche']);
        return new Response(json_encode($jsonContent));


    }

    /**

     * @Route("/AddMatche",name="AddMatche")
     */
    function AddMatche(Request $request,NormalizerInterface $normalizer){
        $em=$this->getDoctrine()->getManager();
        $Equipe=new Matche();
        $Equipe->setDateCreation(new \DateTime('now'));
        $Equipe->setDateMatch(new \DateTime('now'));
        $em->persist($Equipe);
        $em->flush();
        $jsonContent=$normalizer->normalize($Equipe,'json',['groups'=>'Matche']);
        return new Response(json_encode($jsonContent));


    }
    /**

     * @Route("/UpdateMatche/{id}",name="UpdateMatche")
     */
    function UpdateMatche(Request $request,$id,NormalizerInterface $normalizer){
        $em=$this->getDoctrine()->getManager();
        $Equipe=$em->getRepository(Matche::class)->find($id);
        $Equipe->setDateCreation(new \DateTime('now'));
        $Equipe->setDateMatch(new \DateTime('now'));

        $em->flush();
        $jsonContent=$normalizer->normalize($Equipe,'json',['groups'=>'Matche']);
        return new Response("Updated successfully".json_encode($jsonContent));


    }
    /**

     * @Route("/DeleteMatche/{id}",name="DeleteMatche")
     */
    function DeleteMatche(Request $request,$id,NormalizerInterface $normalizer){
        $em=$this->getDoctrine()->getManager();
        $Equipe=$em->getRepository(Matche::class)->find($id);
        $Equipe->setId($id);
        $em->remove($Equipe);

        $em->flush();
        $jsonContent=$normalizer->normalize($Equipe,'json',['groups'=>'Matche']);
        return new Response("Deleted successfully".json_encode($jsonContent));


    }
}
