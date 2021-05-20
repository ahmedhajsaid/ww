<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
/**
 * @Route("/produit")
 */
class ProduitController extends AbstractController
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
     * @Route ("/ltProd", name ="ltprod")
     */
    public function ltprod( NormalizerInterface $normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Produit::class);

        $produits = $repository->findAll();

        $jsonContent = $normalizer->normalize($produits, 'json', ['groups'=>'Produit']);

        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route ("/allProduit", name ="allProduit")
     */
    public function allProduit(NormalizerInterface $normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Produit::class);
        $produit = $repository->findAll();

        $jsonContent = $normalizer->normalize($produit, 'json', ['groups'=>'Produit']);

        return new Response(json_encode($jsonContent));
    }


    /**
     * @Route("/new", name="produit_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('produit_index');
        }

        return $this->render('produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="produit_show", methods={"GET"})
     */
    public function show(Produit $produit): Response
    {
        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }












    /**
     * @Route("/{id}/edit", name="produit_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Produit $produit): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('produit_index');
        }

        return $this->render('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="produit_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Produit $produit): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('produit_index');
    }

    /**
     * @Route("/liste", name="liste")
      */
 public function getProduits(ProduitRepository $repo,SerializerInterface $serializerInterface){
     $produits=$repo->findAll();
     $json=$serializerInterface->serialize($produits,'json',['groups'=>'produits']);
     dump($json);
         die;

 }


    /**
     * @Route("/UpdateProduit/{id}/{reference}/{name}/{image}/{price}/{quantite}",name="UpdateProduit")
     */
    function UpdateProduit (Request $request, $id, NormalizerInterface $normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository(Produit::class)->find($id);

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
     * @Route ("/AddProduit/{reference}/{name}/{image}/{price}/{quantite}", name ="AddProduit")
     */
    public function AddProduit(Request $request, NormalizerInterface $normalizer)
    {


        $em = $this->getDoctrine()->getManager();
        $produit = new Produit();
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
     * @Route("/DeleteProduit/{id}",name="DeleteProduit")
     */
    function DeleteProduit(Request $request,$id,NormalizerInterface $normalizer){
        $em=$this->getDoctrine()->getManager();
        $Produit=$em->getRepository(Produit::class)->find($id);
        $em->remove($Produit);

        $em->flush();
        $jsonContent=$normalizer->normalize($Produit,'json',['groups'=>'Produit']);
        return new Response("Deleted successfully".json_encode($jsonContent));


    }
    /**

     * @Route("/ProduitId/{id}",name="ProduitId")
     */
    function ProduitId(Request $request,$id,NormalizerInterface $normalizer){
        $em=$this->getDoctrine()->getManager();

        $Produit=$em->getRepository(Produit::class)->find($id);
        $jsonContent=$normalizer->normalize($Produit,'json',['groups'=>'Produit']);
        return new Response(json_encode($jsonContent));

    }



    /**
     * @Route ("/findProduit/{id}", name ="findProduit")
     */
    public function findProduit(Request $request, $id, NormalizerInterface $normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository(Produit::class)->find($id);
        $jsonContent = $normalizer->normalize($produit, 'json', ['groups'=>'Produit']);

        return new Response(json_encode($jsonContent));
    }









}
