<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Comp;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
/**
 * @Route("/Produit")
 */
class CompController extends AbstractController
{
    /**
     * @Route("/", name="produit_index", methods={"GET"})
     */
    public function index(): Response
    {
        $produits = $this->getDoctrine()
            ->getRepository(Produit::class)
            ->findAll();

        return $this->render('produit/index.html.twig', [
            'produits' => $produits,
        ]);
    }

    /**
     * @Route ("/ltComp", name ="ltComp")
     */
    public function ltprod( NormalizerInterface $normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Comp::class);

        $produits = $repository->findAll();

        $jsonContent = $normalizer->normalize($produits, 'json', ['groups'=>'Produit']);

        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route ("/allComp", name ="allComp")
     */
    public function allProduit(NormalizerInterface $normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Comp::class);
        $produit = $repository->findAll();

        $jsonContent = $normalizer->normalize($produit, 'json', ['groups'=>'Produit']);

        return new Response(json_encode($jsonContent));
    }



















    /**
     * @Route("/UpdateComp/{id}/{reference}/{name}/{image}/{price}/{quantite}",name="UpdateComp")
     */
    function UpdateProduit (Request $request, $id, NormalizerInterface $normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository(Comp::class)->find($id);

        $produit->setReference($request->get('reference'));
        $produit->setName($request->get('name'));
        $produit->setImage($request->get('image'));
        $produit->setPrice($request->get('price'));
        $produit->setQuantite($request->get('quantite'));
        $em->flush();
        $jsonContent = $normalizer->normalize($produit, 'json', ['groups' => 'Produit']);
        return new Response("Updated successfully" . json_encode($jsonContent));


    }
    /**
     * @Route ("/AddComp/{reference}/{name}/{image}/{price}/{quantite}", name ="AddComp")
     */
    public function AddProduit(Request $request, NormalizerInterface $normalizer)
    {


        $em = $this->getDoctrine()->getManager();
        $produit = new Comp();
        $produit->setReference($request->get('reference'));
        $produit->setName($request->get('name'));
        $produit->setImage($request->get('image'));
        $produit->setPrice($request->get('price'));
        $produit->setQuantite($request->get('quantite'));
        $em->persist($produit);
        $em->flush();
        $jsonContent=$normalizer->normalize($produit,'json',['groups'=>'Produit']);
        return new Response(json_encode($jsonContent));

    }


    /**
     * @Route("/DeleteComp/{id}",name="DeleteComp")
     */
    function DeleteProduit(Request $request,$id,NormalizerInterface $normalizer){
        $em=$this->getDoctrine()->getManager();
        $Produit=$em->getRepository(Comp::class)->find($id);
        $em->remove($Produit);

        $em->flush();
        $jsonContent=$normalizer->normalize($Produit,'json',['groups'=>'Produit']);
        return new Response("Deleted successfully".json_encode($jsonContent));


    }
    /**

     * @Route("/ProduitIdComp/{id}",name="ProduitIdComp")
     */
    function ProduitId(Request $request,$id,NormalizerInterface $normalizer){
        $em=$this->getDoctrine()->getManager();

        $Produit=$em->getRepository(Comp::class)->find($id);
        $jsonContent=$normalizer->normalize($Produit,'json',['groups'=>'Produit']);
        return new Response(json_encode($jsonContent));

    }



    /**
     * @Route ("/findComp/{id}", name ="findComp")
     */
    public function findProduit(Request $request, $id, NormalizerInterface $normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository(Comp::class)->find($id);
        $jsonContent = $normalizer->normalize($produit, 'json', ['groups'=>'Produit']);

        return new Response(json_encode($jsonContent));
    }









}
