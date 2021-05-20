<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Entity\EquipeSearch;
use App\Entity\Invitation;
use App\Entity\Matche;
use App\Entity\Utilisateur;
use App\Form\EquipeSearchType;
use App\Form\EquipeType;
use App\Form\MatchequipeType;
use App\Form\PositionType;
use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\This;
use Symfony\Component\Console\Color;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class EquipeController extends AbstractController
{
    /**
     * @Route("/equipe", name="equipe")
     *
     */
    public function index(Request $request,SerializerInterface $serializer): Response
    {
        if ($this->getUser()) {

        $nomequipe = $this->getUser()->getEquipe()->getNom();
        $repo = $this->getDoctrine()->getRepository(Utilisateur::class);
        $Equipe = $repo->findBy(array('equipe' => $this->getUser()->getEquipe()));
        $json=$serializer->serialize($Equipe,'json',['groups'=>'post:read']);
        dump($json);


        return $this->render('front/equipe.html.twig', ['Equipe' => $Equipe, 'nomequipe' => $nomequipe]);
    }else{
            return $this->redirectToRoute('app_login');
        }

    }
    /**
     * @Route("/calenderrr", name="calenderrr")
     */
    public function match(): Response
    {  $repo=$this->getDoctrine()->getRepository(Matche::class);
        $matches=$repo->findAll();
        $rdv=[];
        foreach ($matches as $match){
            $rdv []=[
                'id'=>$match->getId(),
                'start'=>$match->getDateMatch()->format('Y-m-d H:i:s'),
                'end'=>$match->getDateMatch()->format('Y-m-d H:i:s'),
                'title'=>"Match",




            ];

        }
        $data= json_encode($rdv);
        return $this->render('front/Equipe/match.html.twig',compact('data'));
    }

    /**
     * @return Response
     * @Route("/AfficheEquipe",name="AfficheEquipe")
     */
    public function Affiche(){
        if($this->getUser()){
        $username = $this->getUser()->getUsername();
        $repo=$this->getDoctrine()->getRepository(Utilisateur::class);
        $Utilisateur=$repo->findOneBy(array('email' => $username));
        if($Utilisateur->getEquipe()==null){
            $repo=$this->getDoctrine()->getRepository(Equipe::class);
            $Equipe=$repo->findAll();
            return $this->redirectToRoute('creeequipe');
            //return $this->render('front/Equipe/Affiche.html.twig',['Equipe'=>$Equipe]);
        }else{
            return $this->redirectToRoute('equipe');
        }
        }else{
            return $this->redirectToRoute('equipe');
        }




    }

    /**
     * @Route("/Supp/{id}",name="deleteequipe")
     */
    function Delete($id){
        $repo=$this->getDoctrine()->getRepository(Equipe::class);
        $Equipe=$repo->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($Equipe);
        $em->flush();
        return $this->redirectToRoute('AfficheEquipe');


    }


    /**
     * @param Request $request
     * @return Response
     * @Route("equipe/Add")
     */
    function Add(Request $request,MailerInterface $mailer){
        $Equipe=new Equipe();
     $form=$this->createForm(EquipeType::class,$Equipe);

     $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);
     if($form->isSubmitted()&& $form->isValid())
     {
         $em=$this->getDoctrine()->getManager();
         $username = $this->getUser()->getUsername();
         $repo=$this->getDoctrine()->getRepository(Utilisateur::class);
         $Utilisateur=$repo->findOneBy(array('email' => $username));
         $Utilisateur->setPositionEquipe(1);

         $Equipe->setCapitain($Utilisateur);
         $em->persist($Equipe);
         $em->flush();
         $Utilisateur->setEquipe($Equipe);
         $em->flush();
         $email = (new Email())
             ->from('complexsportiftunis@gmail.com')
             ->to('achref.tirari@esprit.tn')

             ->subject('you have created a team!')
             ->text('Complexes Sportif Sending you E-mail to tell you that you have successfully created a team!');


         $mailer->send($email);
        return $this->redirectToRoute('AfficheEquipe');
     }
     return $this->render('front/Equipe/Add.html.twig',[
         'formequipe'=>$form->createView()
     ]);
    }
    /**
     * @Route("/update/{id}",name="updateequipe")
     */
    function update($id,Request $request){
        $repo=$this->getDoctrine()->getRepository(Equipe::class);
        $Equipe=$repo->find($id);
        $form=$this->createForm(EquipeType::class,$Equipe);
        $form->add('update',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('AfficheEquipe');
        }
        return $this->render('front/Equipe/Update.html.twig',[
            'fequipe'=>$form->createView()
        ]);

    } /**
 * @Route("/request/{id}",name="requestequipe")
 */
    function request($id,Request $request){
        $invitation=new Invitation();
        $invitation->setValide(0);
        $invitation->setUtilisateur($this->getUser()->getId());
        $invitation->setEquipe($id);
        $invitation->setType("request");

        $repo=$this->getDoctrine()->getRepository(Invitation::class);


            $em=$this->getDoctrine()->getManager();
        $em->persist($invitation);
            $em->flush();
            return $this->redirectToRoute('listrequest');



    }
    /**
     * @Route("/votrerequest",name="votrerequestequipe")
     */
    function votrerequest(){
        $entities = array(Equipe::class);
        $entities=null;
            $repo=$this->getDoctrine()->getRepository(Invitation::class);
            $invitation=$repo->findBy(array('type' => "request",'valide'=>0,'utilisateur'=>$this->getUser()->getId()));

        $repo=$this->getDoctrine()->getRepository(Equipe::class);
        $Equipe=$repo->findAll();

        return $this->render('front/Equipe/votrerequest.html.twig',['invitation'=>$invitation,'Equipe'=>$Equipe]);



    }
    /**
     * @Route("/votredemande",name="votredemande")
     */
    function votredemande(){

        $repo=$this->getDoctrine()->getRepository(Invitation::class);
        $invitation=$repo->findBy(array('type' => "request",'valide'=>0,'equipe'=>$this->getUser()->getEquipe()));

        $repo=$this->getDoctrine()->getRepository(Utilisateur::class);
        $Equipe=$repo->findAll();

        return $this->render('front/Equipe/accepterdemande.html.twig',['invitation'=>$invitation,'Equipe'=>$Equipe]);



    }
    /**
     * @Route("/accepterdem{id}",name="acceperdem")
     */
    function accepterdem($id){
        $repoo=$this->getDoctrine()->getRepository(Utilisateur::class);
        $Utilisateur=$repoo->find($id);
        $repo=$this->getDoctrine()->getRepository(Invitation::class);
        $invitation=$repo->findOneBy(array('type' => "request",'valide'=>0,'equipe'=>$this->getUser()->getEquipe(),'utilisateur'=>$Utilisateur));
        $Utilisateur->setEquipe($this->getUser()->getEquipe());
        $Utilisateur->setPositionequipe(0);
        $invitation->setValide(1);
        $em=$this->getDoctrine()->getManager();
        $em->persist($invitation);
        $em->persist($Utilisateur);

        $em->flush();




        return $this->redirectToRoute('votredemande');



    }
    /**
     * @Route("/fixture", name="fixture")
     */
    public function fixture(): Response
    {
        return $this->render('front/fixture.html.twig');
    }
    /**
     *@Route("/rechercherequipe",name="equiperecherche")
     */
    public function home(Request $request)
    {
        $propertySearch = new EquipeSearch();
        $form = $this->createForm(EquipeSearchType::class,$propertySearch);
        $form->handleRequest($request);
         $articles= [];

        if($form->isSubmitted() && $form->isValid()) {
           $nom = $propertySearch->getNom();
            if ($nom!="")
                //si on a fourni un nom d'article on affiche tous les articles ayant ce nom
                $articles= $this->getDoctrine()->getRepository(Equipe::class)->findBy(['nom' => $nom] );
            else
                //si si aucun nom n'est fourni on affiche tous les articles
                $articles= $this->getDoctrine()->getRepository(Equipe::class)->findAll();
        }
        return  $this->render('front/Equipe/recherche.html.twig',[ 'form' =>$form->createView(), 'Equipe' => $articles]);
    }
    /**
     *@Route("/creeequipe",name="creeequipe")
     */
    public function creeequipe(Request $request)
    {
        return $this->render('front/Equipe/creeequipe.html.twig');
    }
    /**
     * @return Response
     * @Route("/listrequest",name="listrequest")
     */
    public function listrequest()
    {
        if ($this->getUser()) {
            $username = $this->getUser()->getUsername();
            $repo = $this->getDoctrine()->getRepository(Utilisateur::class);
            $Utilisateur = $repo->findOneBy(array('email' => $username));
            if ($Utilisateur->getEquipeId() == null) {
                $repo = $this->getDoctrine()->getRepository(Equipe::class);
                $Equipe = $repo->findAll();

                return $this->render('front/Equipe/listrequest.html.twig', ['Equipe' => $Equipe]);
            } else {
                return $this->redirectToRoute('equipe');
            }
        } else {
            return $this->redirectToRoute('equipe');
        }
    }
    /**
     * @return Response
     * @Route("/rejoindreequipe",name="rejoindreequipe")
     */
    public function rejoindreequipe(){

                $repo=$this->getDoctrine()->getRepository(Equipe::class);
                $Equipe=$repo->findAll();

        return $this->render('front/Equipe/rejoindreequipe.html.twig',['Equipe'=>$Equipe]);


    } /**
 * @Route("/creerejoindre/{id}",name="creerejoindre")
 */
    function creerejoindre($id,Request $request){
        $repoo=$this->getDoctrine()->getRepository(Equipe::class);
        $Equipe=$repoo->find($id);
        $invitation=new Invitation();
        $invitation->setValide(0);
        $invitation->setUtilisateur($this->getUser());
        $invitation->setEquipe($Equipe);
        $invitation->setType("request");

        $repo=$this->getDoctrine()->getRepository(Invitation::class);


        $em=$this->getDoctrine()->getManager();
        $em->persist($invitation);
        $em->flush();
        return $this->redirectToRoute('rejoindreequipe');


    }
    /**
     * @Route("/setposition/{id}",name="setposition")
     */
    function setposition($id,Request $request){
        $repo=$this->getDoctrine()->getRepository(Utilisateur::class);
        $Equipe=$repo->find($id);
        $form=$this->createForm(PositionType::class,$Equipe);

        $form->add('modifier',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid())

        {
            $em=$this->getDoctrine()->getManager();

            $set = $form->get('POSITION')->getData();


            if($set=="ATT" ){
                $Equipe->setPositionequipe(6);
                $Equipe->setPosition("ATT");
            }elseif($set=="GG"){
                $Equipe->setPositionequipe(1);
                $Equipe->setPosition("GG");
            }elseif($set=="DD1"){
                $Equipe->setPositionequipe(2);
                $Equipe->setPosition("DD");
            }elseif($set=="DD2"){
                $Equipe->setPositionequipe(3);
                $Equipe->setPosition("DD");

            }elseif($set=="MID1"){
                $Equipe->setPositionequipe(4);
                $Equipe->setPosition("MID");
            }elseif($set=="MID2"){
                $Equipe->setPositionequipe(5);
                $Equipe->setPosition("MID");
            }else{
                $Equipe->setPositionequipe(0);
            } $em->persist($Equipe);
            $em->flush();

            return $this->redirectToRoute('equipe');
        }

        return $this->render('front/Equipe/setposition.html.twig',[
            'formequipe'=>$form->createView()
        ]);


    }
    /**
     * @Route("/equipe/invitation",name="equipeinvitation")
     */
    public function Afficheutil(){

        $repo=$this->getDoctrine()->getRepository(Utilisateur::class);

        $Utilisateur=$repo->findAll();


        return $this->render('front/Equipe/inviamis.html.twig',['Utilisateur'=>$Utilisateur]);
    }
    /**
     * @Route("/creeinvit/{id}",name="creeinvit")
     */
    function creeinvit($id,Request $request){
        $repoo=$this->getDoctrine()->getRepository(Utilisateur::class);
        $Equipe=$repoo->find($id);
        $invitation=new Invitation();
        $invitation->setValide(0);
        $invitation->setUtilisateur($Equipe);
        $invitation->setEquipe($this->getUser()->getEquipe());
        $invitation->setType("demande");

        $repo=$this->getDoctrine()->getRepository(Invitation::class);


        $em=$this->getDoctrine()->getManager();
        $em->persist($invitation);
        $em->flush();
        return $this->redirectToRoute('equipeinvitation');


    }
    /**
     * @Route("/accept",name="accept")
     */
    function accept(){

        $repo=$this->getDoctrine()->getRepository(Invitation::class);
        $invitation=$repo->findBy(array('type' => "demande",'valide'=>0,'utilisateur'=>$this->getUser()->getId()));

        $repo=$this->getDoctrine()->getRepository(Equipe::class);
        $Equipe=$repo->findAll();

        return $this->render('front/Equipe/demandeequipe.html.twig',['invitation'=>$invitation,'Equipe'=>$Equipe]);



    }
    /**
     * @Route("/accepter/equipe{id}",name="accepterequipe")
     */
    function accepterequipe($id){
        $repoo=$this->getDoctrine()->getRepository(Equipe::class);
        $Utilisateur=$repoo->find($id);
        $repo=$this->getDoctrine()->getRepository(Invitation::class);
        $invitation=$repo->findOneBy(array('type' => "demande",'valide'=>0,'equipe'=>$Utilisateur,'utilisateur'=>$this->getUser()));
        $this->getUser()->setEquipe($Utilisateur);
        $this->getUser()->setPositionequipe(0);
        $invitation->setValide(1);
        $em=$this->getDoctrine()->getManager();
        $em->persist($invitation);
        $em->persist($Utilisateur);
        $em->persist($this->getUser());

        $em->flush();




        return $this->redirectToRoute('equipe');



    }

    /**
     * @param Request $request
     * @return Response
     * @Route("equipe/creematch",name="creematch")
     */
    function creematch(Request $request,MailerInterface $mailer){
        $Equipe=new Matche();
        $form=$this->createForm(MatchequipeType::class,$Equipe);

        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();

            $repo=$this->getDoctrine()->getRepository(Matche::class);
            $Equipe->setDateCreation(new \DateTime('now'));
            $Equipe->setEquipe2($this->getUser()->getEquipe());
            if($Equipe->getDateCreation()>$Equipe->getDateMatch()){
                return $this->redirectToRoute('creematch');
            }else{
            $em->persist($Equipe);
            $em->flush();
                return $this->redirectToRoute('equipe');
            }
        }
        return $this->render('front/Equipe/creematch.html.twig',[
            'formequipe'=>$form->createView()
        ]);
    }

    /**

     * @Route("/AllEquipe",name="AllEquipe")
     */
    function AllEquipe(NormalizerInterface $normalizer){
        $repo=$this->getDoctrine()->getRepository(Equipe::class);
        $Equipe=$repo->findAll();
        $jsonContent=$normalizer->normalize($Equipe,'json',['groups'=>'Invitation']);
        return new Response(json_encode($jsonContent));


    }
    /**

     * @Route("/EquipeId/{id}",name="EquipeId")
     */
    function EquipeId(Request $request,$id,NormalizerInterface $normalizer){
        $em=$this->getDoctrine()->getManager();

        $Equipe=$em->getRepository(Equipe::class)->find($id);
        $jsonContent=$normalizer->normalize($Equipe,'json',['groups'=>'Invitation']);
        return new Response(json_encode($jsonContent));


    }
    /**

     * @Route("/EquipeNom/{nom}",name="EquipeNom")
     */
    function EquipeNom(Request $request,$nom,NormalizerInterface $normalizer){
        $em=$this->getDoctrine()->getManager();

        $Equipe=$em->getRepository(Equipe::class)->findBy(array('nom' => $nom));
        $jsonContent=$normalizer->normalize($Equipe,'json',['groups'=>'Invitation']);
        return new Response(json_encode($jsonContent));


    }

    /**

     * @Route("/AddEquipe/{nom}/{nbr}/{id}",name="AddEquipe")
     */
    function AddEquipe(Request $request,$nom,$nbr,$id,NormalizerInterface $normalizer,MailerInterface $mailer){
        $em=$this->getDoctrine()->getManager();


        $User=$em->getRepository(Utilisateur::class)->find($id);
        $Equipe=new Equipe();
        $Equipe->setNom($nom);
        $Equipe->setNbreJoueur($nbr);
        $Equipe->setCapitain($User);
        $em->persist($Equipe);
        $em->flush();
        $User->setEquipe($Equipe);
        $User->setPositionEquipe(0);
        $em->flush();
        $email = (new Email())
            ->from('complexsportiftunis@gmail.com')
            ->to($User->getEmail())

            ->subject('you have created a team  !')
            ->text('Complexes Sportif Sending you E-mail to tell you that you have successfully created a team!');


        $mailer->send($email);
        $jsonContent=$normalizer->normalize($Equipe,'json',['groups'=>'Invitation']);
        return new Response(json_encode($jsonContent));


    }
    /**

     * @Route("/UpdateEquipe/{id}",name="UpdateEquipe")
     */
    function UpdateEquipe(Request $request,$id,NormalizerInterface $normalizer){
        $em=$this->getDoctrine()->getManager();
        $Equipe=$em->getRepository(Equipe::class)->find($id);
        $Equipe->setNom($request->get('nom'));
        $Equipe->setNbreJoueur($request->get('nbr'));

        $em->flush();
        $jsonContent=$normalizer->normalize($Equipe,'json',['groups'=>'Invitation']);
        return new Response("Updated successfully".json_encode($jsonContent));


    }
    /**

     * @Route("/DeleteEquipe/{id}",name="UpdateEquipe")
     */
    function DeleteEquipe(Request $request,$id,NormalizerInterface $normalizer){
        $em=$this->getDoctrine()->getManager();
        $Equipe=$em->getRepository(Equipe::class)->find($id);
        $em->remove($Equipe);

        $em->flush();
        $jsonContent=$normalizer->normalize($Equipe,'json',['groups'=>'Invitation']);
        return new Response("Deleted successfully".json_encode($jsonContent));


    }



}
