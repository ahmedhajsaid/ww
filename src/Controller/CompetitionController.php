<?php

namespace App\Controller;
use App\Entity\ContactAdmin;
use App\Entity\Searchprix;
use App\Entity\Utilisateur;
use App\Entity\Categorie;
use App\Entity\Competition;
use App\Form\CompetitionType;
use App\Form\ContactcompType;
use App\Form\CONTACTType;
use App\Form\PropertySearchType;
use App\Form\CategorySearchType;
use App\Form\PriceSearchType;
use App\Entity\PriceSearch;
use App\Entity\PropertySearch;
use App\Notification\ContactNotification;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormTypeInterface;
use App\Repository\CompetitionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormBuilderInterface;
use App\Entity\CategorySearch;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class CompetitionController extends AbstractController
{
    /**
     * @Route("/competition", name="competition")
     */
    public function index(): Response
    {

        return $this->render('Admin/Competition/index.html.twig', [
            'controller_name' => 'CompetitionController',
        ]);
    }

    /**
     * @param CompetitionRepository $repository
     * @return Response
     * @Route("/Affichecompetition",name="Affichecompetition")
     */

    public function Affiche(Request $request){










        $propertySearch = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class,$propertySearch);
        $form->handleRequest($request);

        $Competition= [];

        if($form->isSubmitted() && $form->isValid())


            $Competition= $this->getDoctrine()->getRepository(Competition::class)->findAll();

        {

            $nom = $propertySearch->getDesignation();
            if ($nom!="")

                $Competition= $this->getDoctrine()->getRepository(Competition::class)->findBy(['designation' => $nom] );
            else
                $Competition= $this->getDoctrine()->getRepository(Competition::class)->findAll();
        }

        return $this->render('Admin/Competition/listeCompetition.html.twig',
            [ 'formrech' =>$form->createView(), 'Competition' => $Competition]);











    }














    /**
     *@Route("/su/{id}", name="supprimer")
     *
     */
    public function del($id,CompetitionRepository $repository){
        $Competition=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($Competition);
        $em->flush();
        return $this->redirectToRoute('Affichecompetition');


    }



    /**
     * @param Request $request
     * @return Response
     * @Route("ajout", name="ajout")
     */
    public function addComppetition(Request $request){
        $competition=new Competition();
        $form=$this->createForm(CompetitionType::class,$competition);
        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($competition);
            $em->flush();
            return $this->redirectToRoute('Affichecompetition');
        }
        return $this->render('Admin/Competition/add.html.twig',[

            'form'=>$form->createView()

        ]);

    }

    /**
     * @param Request $request

     * @Route("updatecomp/{id}",name="updatecomp")
     */
    public function Update(CompetitionRepository $repository,Request $request ,$id){
        $Competition=$repository->find($id);
        $form=$this->createForm(CompetitionType::class,$Competition);
        $form->add('Modifier',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('Affichecompetition');

        }
        return $this->render('Admin/Competition/Update.html.twig',[

            'f'=>$form->createView()
        ]);






    }
    /**
     * @param Request $request

     * @Route("participe/{id}",name="participe")
     */
    public function participe(CompetitionRepository $repository,Request $request ,$id,Competition $competition,ContactNotification $contactNotification){

        $form=$this->createForm(CONTACTType::class);
        $form->handleRequest($request);




        return $this->redirectToRoute('contact');



        return $this->render('contact.html.twig',[


            'contactForm'=>$form->createView()
        ]);






    }

    /**
     * @param CompetitionRepository $repository
     * @return Response
     * @Route ("/Competition", name="CompetitionClient")
     */
    public function AfficheClient(CompetitionRepository  $repository){

        $competitions = $repository->findAll();
        return $this->render('front/competition.html.twig',['Competition'=>$competitions,]);
    }


    /**

     * @Route ("/map")
     */

    public function mappAction(){


        return $this->render('Admin/Competition/map.html.twig');



    }





    /**
     * @Route("/art_cat/", name="article_par_cat")
     * Method({"GET", "POST"})
     */
    public function articlesParCategorie(Request $request) {



        $categorySearch = new CategorySearch();
        $form = $this->createForm(CategorySearchType::class,$categorySearch);
        $form->handleRequest($request);

        $Competition= [];

        if($form->isSubmitted() && $form->isValid()) {

            $category = $categorySearch->getCategorie();
            if ($category!="")

                $Competition= $this->getDoctrine()->getRepository(Competition::class)->findBy(['categorie' => $category] );
            else
                $Competition= $this->getDoctrine()->getRepository(Competition::class)->findAll();
        }

        return $this->render('Admin/Competition/listeCompetition.html.twig',
            [ 'form' =>$form->createView(), 'Competition' => $Competition]);

    }




    /**
     * @Route("/art_prix/", name="article_par_prix")
     * Method({"GET"})
     */
    public function articlesParPrix( Request $request)
    {

        $priceSearch = new PriceSearch();
        $form = $this->createForm(PriceSearchType::class,$priceSearch);
        $form->handleRequest($request);
        $Competition= [];
        if($form->isSubmitted() && $form->isValid()) {
            $minPrice = $priceSearch->getMinPrice();
            $maxPrice = $priceSearch->getMaxPrice();

            $Competition= $this->getDoctrine()->
            getRepository(Competition::class)->findByprixParticipation($minPrice,$maxPrice);
        }
        return $this->render('Admin/Competition/articlesParPrix.html.twig',
            [ 'form' =>$form->createView(), 'Competition' => $Competition]);
    }


    /**
     * @Route("/calender", name="calender")
     */
    public function competition(): Response
    {  $repo=$this->getDoctrine()->getRepository(Competition::class);
        $matches=$repo->findAll();
        $rdv=[];
        foreach ($matches as $match){
            $rdv []=[
                'id'=>$match->getId(),
                'start'=>$match->getDateCreation()->format('Y-m-d H:i:s'),
                'end'=>$match->getDateDebut(),
                'title'=>$match->getDesignation()





            ];

        }
        $data= json_encode($rdv);
        return $this->render('Admin/Competition/calander.html.twig',compact('data'));
    }





























    /**
     * @Route("/liste",name="liste")
     *
     */
    public function AfficheAllcomp(NormalizerInterface $normalizer){

        $repo=$this->getDoctrine()->getRepository(Competition::class);
        $competition=$repo->findAll();
        $jsonContent=$normalizer->normalize($competition,'json',['groups'=>'Competition']);
        return new Response(json_encode($jsonContent));
    }


    /**

     * @Route("/CompetitionId/{id}",name="CompetitionId")
     */
    function CompetitionId (Request $request,$id,NormalizerInterface $normalizer){

        $em=$this->getDoctrine()->getManager();

        $competition = $em->getRepository(Competition::class)->find($id);
        $jsonContent = $normalizer->normalize($competition, 'json', ['groups' => 'competition']);
        return new Response(json_encode($jsonContent));
    }



    /**
     * @Route("/AddCompetition/{designation}/{dateDebut}/{nbreEquipes}/{prixParticipation}",name="AddCompetition")
     */
    function AddCompetition(Request $request, NormalizerInterface $normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $competition = new Competition();
        $competition->setDesignation($request->get('designation'));

        $competition->setDateDebut($request->get('dateDebut'));
        $competition->setNbreEquipes($request->get('nbreEquipes'));
        $competition->setPrixParticipation($request->get('prixParticipation'));


        $em->persist($competition);
        $em->flush();
        $jsonContent = $normalizer->normalize($competition, 'json', ['groups' => 'competition']);
        return new Response(json_encode($jsonContent));


    }

    /**

     * @Route("/DeleteCompetition/{id}",name="DeleteCompetition")
     */
    function DeleteCompetition(Request $request,$id,NormalizerInterface $normalizer){
        $em=$this->getDoctrine()->getManager();
        $competition=$em->getRepository(Competition::class)->find($id);
        $em->remove($competition);

        $em->flush();
        $jsonContent=$normalizer->normalize($competition,'json',['groups'=>'competition']);
        return new Response("Deleted successfully".json_encode($jsonContent));


    }

    /**
     * @Route("/UpdateCompetition/{id}/{designation}/{dateDebut}/{nbreEquipes}/{prixParticipation}",name="UpdateCompetition")
     */
    function UpdateCompetition (Request $request, $id, NormalizerInterface $normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $competition = $em->getRepository(Competition::class)->find($id);

        $competition->setDesignation($request->get('designation'));
        $competition->setDateDebut($request->get('dateDebut'));
        $competition->setNbreEquipes($request->get('nbreEquipes'));
        $competition->setPrixParticipation($request->get('prixParticipation'));

        $em->flush();
        $jsonContent = $normalizer->normalize($competition, 'json', ['groups' => 'competition']);
        return new Response("Updated successfully" . json_encode($jsonContent));


    }
}
