<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/cart", name="cart_")
 */
class CartController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(SessionInterface $session, ProduitRepository $produitRepository)
    {
        $panier = $session->get("panier", []);

        // On "fabrique" les données
        $dataPanier = [];
        $total = 0;

        foreach($panier as $id => $quantite){
            $produits = $produitRepository->find($id);
            $dataPanier[] = [
                "produit" => $produits,
                "quantite" => $quantite
            ];
            $total += $produits->getPrice() * $quantite;
        }

        return $this->render('cart/index.html.twig', compact("dataPanier", "total"));
    }

    /**
     * @Route("/add/{id}", name="add")
     */
    public function add(Produit $produits, SessionInterface $session)
    {
        // On récupère le panier actuel
        $panier = $session->get("panier", []);
        $id = $produits->getId();

        if(!empty($panier[$id])){
            $panier[$id]++;
        }else{
            $panier[$id] = 1;
        }

        // On sauvegarde dans la session
        $session->set("panier", $panier);

        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/remove/{id}", name="remove")
     */
    public function remove(Produit $produits, SessionInterface $session)
    {
        // On récupère le panier actuel
        $panier = $session->get("panier", []);
        $id = $produits->getId();

        if(!empty($panier[$id])){
            if($panier[$id] > 1){
                $panier[$id]--;
            }else{
                unset($panier[$id]);
            }
        }

        // On sauvegarde dans la session
        $session->set("panier", $panier);

        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Produit $produits, SessionInterface $session)
    {
        // On récupère le panier actuel
        $panier = $session->get("panier", []);
        $id = $produits->getId();

        if(!empty($panier[$id])){
            unset($panier[$id]);
        }

        // On sauvegarde dans la session
        $session->set("panier", $panier);

        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/delete", name="delete_all")
     */
    public function deleteAll(SessionInterface $session)
    {
        $session->remove("panier");

        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/success", name="success")
     */
    public function success()
    {


        return $this->render("cart/success.html.twig");
    }

    /**
     * @Route("/error", name="error")
     */
    public function error()
    {


        return $this->render("cart/error.html.twig");
    }


    /**
     * @Route("/create-checkout-session", name="checkout")
     */
    public function checkout()
    {
      \Stripe\stripe::setApiKey('sk_test_51IkN2tIXnUEJC3Gk5kC024wdGHrw4tn1L4xaUNyAPaFUAQOQJJOm1GExLhFpmqRFUztYbfzTo2NQa6Yxhafu3ER900qZOG8mQe');

        $session = \Stripe\Checkout\Session::create([
    payment_method_types => ['card'],
    line_items => [[
        price_data => [
            currency => 'usd',
        product_data => [
                name => 'T-shirt',
        ],
        unit_amount => 2000,
      ],
        quantity => 1,
    ]],
    mode => 'payment',
    success_url => $this ->generateurl('success', [],UrlGeneratorInterface::ABSOLUTE_URL),
            cancel_url => $this ->generateurl('error', [],UrlGeneratorInterface::ABSOLUTE_URL),
  ]);

 return new JsonResponse(['id' => $session->id]);


    }




}