<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Entity\Invitation;
use App\Entity\Utilisateur;
use App\Form\EquipeType;
use App\Form\InvitationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class InvitationController extends AbstractController
{
    /**
     * @Route("/invitation", name="invitation")
     */
    public function index(): Response
    {
        return $this->render('invitation/index.html.twig', [
            'controller_name' => 'InvitationController',
        ]);
    }
    /**
     * @Route("/AfficheInvitation",name="AfficheInvitation")
     */
    function Affiche(){
        $repo=$this->getDoctrine()->getRepository(Invitation::class);
        $Invitation=$repo->findAll();
        return $this->render('invitation/Affiche.html.twig',['Invitation'=>$Invitation]);
    }
    /**
     * @Route("/SuppInvitation/{id}",name="deleteinvitation")
     */
    function Delete($id){
        $repo=$this->getDoctrine()->getRepository(Invitation::class);
        $Invitation=$repo->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($Invitation);
        $em->flush();
        return $this->redirectToRoute('AfficheInvitation');


    }
    /**
     * @param Request $request
     * @return Response
     * @Route("invitation/Add")
     */
    function Add(Request $request){
        $Invitation=new Invitation();
        $form=$this->createForm(InvitationType::class,$Invitation);

        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($Invitation);
            $em->flush();
            return $this->redirectToRoute('AfficheInvitation');
        }
        return $this->render('invitation/Add.html.twig',[
            'forminvitation'=>$form->createView()
        ]);
    }
    /**
     * @Route("/updateinvitation/{id}",name="updateinvitation")
     */
    function update($id,Request $request){
        $repo=$this->getDoctrine()->getRepository(Invitation::class);
        $Equipe=$repo->find($id);
        $form=$this->createForm(InvitationType::class,$Equipe);
        $form->add('update',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('AfficheInvitation');
        }
        return $this->render('invitation/Update.html.twig',[
            'finvitation'=>$form->createView()
        ]);

    }
    /**

     * @Route("/AllInvitation",name="AllInvitation")
     */
    function AllInvitation(NormalizerInterface $normalizer){
        $repo=$this->getDoctrine()->getRepository(Invitation::class);
        $Equipe=$repo->findAll();
        $jsonContent=$normalizer->normalize($Equipe,'json',['groups'=>'Invitation']);
        return new Response(json_encode($jsonContent));


    }
    /**

     * @Route("/InvitationId/{id}",name="InvitationId")
     */
    function InvitationId(Request $request,$id,NormalizerInterface $normalizer){
        $em=$this->getDoctrine()->getManager();

        $Equipe=$em->getRepository(Invitation::class)->find($id);
        $jsonContent=$normalizer->normalize($Equipe,'json',['groups'=>'Invitation']);
        return new Response(json_encode($jsonContent));


    }
    /**

     * @Route("/InvitationNom/{nom}",name="InvitationNom")
     */
    function InvitationNom(Request $request,$nom,NormalizerInterface $normalizer){
        $em=$this->getDoctrine()->getManager();
        $Equipee=$em->getRepository(Equipe::class)->findBy(array('nom' => $nom));
        foreach ($Equipee as $obj){
            $Equipe=$em->getRepository(Invitation::class)->findBy(array('equipe' => $obj->getID()));
        }

        $jsonContent=$normalizer->normalize($Equipe,'json',['groups'=>'Invitation']);
        return new Response(json_encode($jsonContent));


    }

    /**

     * @Route("/AddInvitation/{type}/{equipeid}/{utilisateurid}/{valide}",name="AddInvitation")
     */
    function AddInvitation(Request $request,NormalizerInterface $normalizer,$type,$equipeid,$utilisateurid,$valide){
        $em=$this->getDoctrine()->getManager();
        $Equipe=$em->getRepository(Equipe::class)->find($equipeid);
        $utilisateur=$em->getRepository(Utilisateur::class)->find($utilisateurid);
        $Invitation=new Invitation();
        $Invitation->setType($type);
        $Invitation->setValide($valide);
        $Invitation->setEquipe($Equipe);
        $Invitation->setUtilisateur($utilisateur);

        $em->persist($Invitation);
        $em->flush();
        $jsonContent=$normalizer->normalize($Invitation,'json',['groups'=>'Invitation']);
        return new Response(json_encode($jsonContent));


    }
    /**

     * @Route("/UpdateInvitation/{id}",name="UpdateInvitation")
     */
    function UpdateInvitation(Request $request,$id,NormalizerInterface $normalizer){
        $em=$this->getDoctrine()->getManager();
        $Equipe=$em->getRepository(Invitation::class)->find($id);

        $Equipe->setValide(1);

        $em->flush();
        $E=$em->getRepository(Equipe::class)->find($Equipe->getEquipe()->getId());
        $User=$em->getRepository(Utilisateur::class)->find($Equipe->getUtilisateur()->getId());
        $User->setEquipe($E);
        $User->setPositionEquipe(0);
        $em->flush();
        $jsonContent=$normalizer->normalize($Equipe,'json',['groups'=>'Invitation']);
        return new Response("Updated successfully".json_encode($jsonContent));


    }
    /**

     * @Route("/DeleteInvitation/{id}",name="DeleteInvitation")
     */
    function DeleteInvitation(Request $request,$id,NormalizerInterface $normalizer){
        $em=$this->getDoctrine()->getManager();
        $Equipe=$em->getRepository(Invitation::class)->find($id);
        $em->remove($Equipe);

        $em->flush();
        $jsonContent=$normalizer->normalize($Equipe,'json',['groups'=>'Invitation']);
        return new Response("Deleted successfully".json_encode($jsonContent));


    }
}
