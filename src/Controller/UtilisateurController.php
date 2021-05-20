<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\ClientType;
use App\Form\ProprietaireType;
use App\Form\UtilisateurType;
use App\Form\AdminType;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class UtilisateurController extends AbstractController
{
    /**
     * @Route("/utilisateur", name="utilisateur")
     */
    public function index(): Response
    {
        return $this->render('utilisateur/index.html.twig', [
            'controller_name' => 'UtilisateurController',
        ]);
    }

    /**
     * @Route("/inscrit", name="inscrit")
     */
    public function inscrit(): Response
    {
        return $this->render('inscrit/inscrit.html.twig');
    }

    /**
     * @return Response
     * @Route("/AfficheUtilisateur",name="AfficheUtilisateur")
     */
    public function Affiche()
    {
        $repo = $this->getDoctrine()->getRepository(Utilisateur::class);
        $Utilisateur = $repo->findAll();
        return $this->render('Admin/utilisateur/Affiche.html.twig', ['Utilisateur' => $Utilisateur]);
    }

    /**

     * @return Response
     * @Route("/AfficheArbitre",name="AfficheArbitre")
     */
    public function Affichearbire(UtilisateurRepository $repository)
    {

        $Utilisateur=$repository->findByRole('ROLE_ARBITRE');

        return $this->render('Admin/utilisateur/Affichearbitre.html.twig', ['Utilisateur' => $Utilisateur]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @return Response
     * @Route("/AfficheProp",name="AfficheProp")
     */
    public function AfficheProprietaire(UtilisateurRepository $repository)
    {

        $Utilisateur=$repository->findByRole('ROLE_PROP');
        return $this->render('admin/utilisateur/AfficheProprietaire.html.twig', ['Utilisateur' => $Utilisateur]);
    }

    /**
     * @Route("/SuppUtilisateur/{id}",name="d")
     */
    function Delete($id,UtilisateurRepository $repository)
    {

        $Utilisateur = $repository->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($Utilisateur);
        $em->flush();
        $roles = $this->getUser()->getRoles();

        if (in_array('ROLE_ADMIN', $roles, true)){
            return $this->redirectToRoute('AfficheProp');
        }elseif (in_array('ROLE_PROP', $roles, true)){
            return $this->redirectToRoute('AfficheArbitre');
        }

    }

    /**
     * @IsGranted("ROLE_PROP")
     * @param Request $request
     * @Route("/AjouterArbitre",name="ad")
     */
    function Add(Request $request, MailerInterface $mailer)
    {
        $Utilisateur = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $Utilisateur);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $Utilisateur->setrolesarbitre();
            $em->persist($Utilisateur);
            $em->flush();
            $email = (new Email())
                ->from('complexsportiftunis@gmail.com')
                ->to('sahar.gharrad@esprit.tn')
                ->subject('you have created a user!')
                ->text('Complexes Sportif Sending you E-mail to tell you that you have successfully created an account!');


            $mailer->send($email);
            return $this->redirectToRoute('AfficheArbitre');
        }
        return $this->render('Admin/utilisateur/AjouterArbitre.html.twig', ['form' => $form->createView()]);
    }


    /**
     * @IsGranted("ROLE_ADMIN")
     * @param Request $request
     * @Route("/AjouterProp",name="ap")
     */
    function AddProp(Request $request, MailerInterface $mailer)
    {
        $Utilisateur = new Utilisateur();
        $form = $this->createForm(ProprietaireType::class, $Utilisateur);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $Utilisateur->setrolesprop();
            $em->persist($Utilisateur);
            $em->flush();
            $email = (new Email())
                ->from('complexsportiftunis@gmail.com')
                ->to('sahar.gharrad@esprit.tn')
                ->subject('you have created a user!')
                ->text('Complexes Sportif Sending you E-mail to tell you that you have successfully created an account!');


            $mailer->send($email);
            return $this->redirectToRoute('AfficheProp');
        }
        return $this->render('Admin/utilisateur/AjouterProprietaire.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @IsGranted("ROLE_PROP")
     * @param $id
     * @param Request $request
     * @return Response
     * @Route("/UpdateUtilisateur/{id}",name="a")
     */
    function update($id, Request $request)
    {
        $repo = $this->getDoctrine()->getRepository(Utilisateur::class);
        $Utilisateur = $repo->find($id);
        $form = $this->createForm(UtilisateurType::class, $Utilisateur);
        $form->add('Update', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('AfficheArbitre');
        }
        return $this->render('utilisateur/Update.html.twig', ['f' => $form->createView()]);

    }
    /**
     * @IsGranted("ROLE_ARBITRE")
     * @param $id
     * @param Request $request
     * @return Response
     * @Route("/UpdateArbitre/{id}",name="UpdateArbitre")
     */
    function updateArbitre($id, Request $request)
    {
        $repo = $this->getDoctrine()->getRepository(Utilisateur::class);
        $Utilisateur = $repo->find($id);
        $form = $this->createForm(UtilisateurType::class, $Utilisateur);
        $form->add('Update', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('CompteArbitre');
        }
        return $this->render('utilisateur/Update.html.twig', ['f' => $form->createView()]);

    }

    /**
     * @IsGranted("ROLE_PROP")
     * @param $id
     * @param Request $request
     * @return Response
     * @Route("/UpdateProprietaire/{id}",name="updateProp")
     */
    function updateProp($id, Request $request)
    {
        $repo = $this->getDoctrine()->getRepository(Utilisateur::class);
        $Utilisateur = $repo->find($id);
        $form = $this->createForm(ProprietaireType::class, $Utilisateur);
        $form->add('Update', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('CompteProp');
        }
        return $this->render('admin/utilisateur/UpdateProprietaire.html.twig', ['f' => $form->createView()]);

    }
    /**
     * @IsGranted("ROLE_ADMIN")
     * @param $id
     * @param Request $request
     * @return Response
     * @Route("/UpdateProprietaireAdmin/{id}",name="updatePropAdmin")
     */
    function updatePropAdmin($id, Request $request)
    {
        $repo = $this->getDoctrine()->getRepository(Utilisateur::class);
        $Utilisateur = $repo->find($id);
        $form = $this->createForm(ProprietaireType::class, $Utilisateur);
        $form->add('Update', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('AfficheProp');
        }
        return $this->render('admin/utilisateur/UpdateProprietaire.html.twig', ['f' => $form->createView()]);

    }

    /**
     * @IsGranted("ROLE_USER")
     * @param $id
     * @param Request $request
     * @return Response
     * @Route("/UpdateUser/{id}",name="updateUser")
     */

    function updateClient($id, Request $request)
    {
        $repo = $this->getDoctrine()->getRepository(Utilisateur::class);
        $Utilisateur = $repo->find($id);
        $form = $this->createForm(ClientType::class, $Utilisateur);
        $form->add('Update', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('CompteClient');
        }
        return $this->render('admin/utilisateur/updateuser.html.twig', ['f' => $form->createView()]);

    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @param $id
     * @param Request $request
     * @return Response
     * @Route("/UpdateAdmin/{id}",name="updateAdmin")
     */

    function updateAdmin($id, Request $request)
    {
        $repo = $this->getDoctrine()->getRepository(Utilisateur::class);
        $Utilisateur = $repo->find($id);
        $form = $this->createForm(AdminType::class, $Utilisateur);
        $form->add('Update', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('CompteAdmin');
        }
        return $this->render('admin/utilisateur/UpdateProprietaire.html.twig', ['f' => $form->createView()]);

    }


    /**
     * @IsGranted("ROLE_ADMIN")
     * @param $id
     * @param Request $request
     * @return Response
     * @Route("/CompteAdmin",name="CompteAdmin")
     */

    public function CompteAdmin()
    {
        $username = $this->getUser()->getUsername();
        $repo = $this->getDoctrine()->getRepository(Utilisateur::class);
        $Utilisateur = $repo->findOneBy(array('email' => $username));

        return $this->render('admin/profil/CompteAdmin.html.twig', ['Utilisateur' => $Utilisateur]);
    }


    /**
     * @IsGranted("ROLE_PROP")
     * @param $id
     * @param Request $request
     * @return Response
     * @Route("/CompteProp",name="CompteProp")
     */

    public function CompteProp()
    {
        $username = $this->getUser()->getUsername();
        $repo = $this->getDoctrine()->getRepository(Utilisateur::class);
        $Utilisateur = $repo->findOneBy(array('email' => $username));

        return $this->render('admin/profil/CompteProp.html.twig', ['Utilisateur' => $Utilisateur]);
    }
    /**
     * @IsGranted("ROLE_USER")
     * @param $id
     * @param Request $request
     * @return Response
     * @Route("/CompteClient",name="CompteClient")
     */

    public function CompteClient()
    {
        $username = $this->getUser()->getUsername();
        $repo = $this->getDoctrine()->getRepository(Utilisateur::class);
        $Utilisateur = $repo->findOneBy(array('email' => $username));

        return $this->render('admin/profil/CompteClient.html.twig', ['Utilisateur' => $Utilisateur]);
    }
    /**
     * @IsGranted("ROLE_ARBITRE")
     * @param $id
     * @param Request $request
     * @return Response
     * @Route("/CompteArbitre",name="CompteArbitre")
     */

    public function CompteArbitre()
    {
        $username = $this->getUser()->getUsername();
        $repo = $this->getDoctrine()->getRepository(Utilisateur::class);
        $Utilisateur = $repo->findOneBy(array('email' => $username));

        return $this->render('admin/profil/CompteArbitre.html.twig', ['Utilisateur' => $Utilisateur]);
    }













//********************************************Mobile***********************************************************

    /**
     * @Route("/allUsers", name="allUsers")
     */
    public function AllUsers(NormalizerInterface $Normalizer)
    {
        $repository =$this->getDoctrine()->getRepository(Utilisateur::class);
        $utilisateur=$repository->findAll();

        $jsonContent=$Normalizer->normalize($utilisateur, 'json',['groups'=>'post:read']);
        //return $this->render('')
        return new Response(json_encode($jsonContent));

    }
    /**
     * @Route("/User/{id}", name="User")

     */
    public function UtilisateurId(Request $request,$id,NormalizerInterface $Normalizer)
    {
        $em=$this->getDoctrine()->getManager();
        $utilisateur= $em->getRepository(Utilisateur::class)->find($id);
        $jsonContent=$Normalizer->normalize($utilisateur, 'json',['groups'=>'post:read']);
        return new Response(json_encode($jsonContent));

    }

    /**
     * @Route("/AddUsers/{email}/{mdp}/{nom}/{prenom}/{telephone}/{position}/{role}", name="AddUser")
     */

    public function AddUsers(Request $request,NormalizerInterface $Normalizer,$email,$mdp,$nom,$prenom,$telephone,$position,$role,MailerInterface $mailer)
    {
        $em = $this->getDoctrine()->getManager();
        $utilisateur = new Utilisateur();

        $utilisateur->setEmail($email);
        $utilisateur->setPassword($mdp);
        $utilisateur->setNom($nom);
        $utilisateur->setPrenom($prenom);
        $utilisateur->setTelephone($telephone);
        $utilisateur->setPosition($position);
        //$utilisateur->setCategorie($categorie);
        if($role=="[\"ROLE_USER\"]"){
            $utilisateur->setrolesuser();
        }elseif ($role=="[\"ROLE_PROP\"]"){
            $utilisateur->setrolesprop();
        }elseif ($role=="[\"ROLE_ARBITRE\"]"){
            $utilisateur->setrolesarbitre();
        }
        $em->persist($utilisateur);
        $em->flush();
        $email = (new Email())
            ->from('complexsportiftunis@gmail.com')
            ->to($utilisateur->getEmail())
            ->subject('you have created a user!')
            ->text('Complexes Sportif Sending you E-mail to tell you that you have successfully created an account!');


        $mailer->send($email);

        $jsonContent = $Normalizer->normalize($utilisateur, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsonContent));
    }





    /**
     * @Route("/UpUser/{email}/{nom}/{prenom}/{telephone}/{position}", name="Userrr")
     */

    public function UpdateUser($email,$nom,$prenom,$telephone,$position,NormalizerInterface $Normalizer){
        $em=$this->getDoctrine()->getManager();
        $utilisateur= $em->getRepository(Utilisateur::class)->findBy(array('email' => $email));
        foreach ($utilisateur as $u) {
            $u->setEmail($email);
            $u->SetNom($nom);
            $u->SetPrenom($prenom);
            $u->SetTelephone($telephone);
            $u->SetPosition($position);
        }
        $em->flush();
        $jsonContent=$Normalizer->normalize($utilisateur,'json',['groups'=>'post:read']);
        return new Response("information updated successfully".json_encode($jsonContent));


    }

    /**
     * @Route("/UpdateMdp/{email}/{password}", name="Userr")
     */

    public function UpdateMdp($email,$password,NormalizerInterface $Normalizer){
        $em=$this->getDoctrine()->getManager();
        $utilisateur= $em->getRepository(Utilisateur::class)->findby(array('email' => $email));
        foreach ($utilisateur as $u) {
            $u->setEmail($email);
            $u->SetPassword($password);
        }
        $em->flush();
        $jsonContent=$Normalizer->normalize($utilisateur,'json',['groups'=>'post:read']);
        return new Response("Password updated successfully".json_encode($jsonContent));


    }


    /**
     * @Route("/SuppUser/{id}", name="User")
     */

    public function SuppUsers(Request $request,NormalizerInterface $Normalizer,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $utilisateur= $em->getRepository(Utilisateur::class)->find($id);
        $em->remove($utilisateur);
        $em->flush();
        $jsonContent=$Normalizer->normalize($utilisateur,'json',['groups'=>'post:read']);
        return new Response("Utilisateur supprimé".json_encode($jsonContent));

    }



    /**
     * @Route("/Login/{email}", name="User")

     */
    public function Login(Request $request,$email,NormalizerInterface $Normalizer,UserPasswordEncoderInterface $passwordEncoder)
    {    $User=new Utilisateur();
        $em=$this->getDoctrine()->getManager();

        $utilisateur= $em->getRepository(Utilisateur::class)->findBy(array('email' => $email));

        $jsonContent = $Normalizer->normalize($utilisateur, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsonContent));


    }


    /**
     * @Route("/user/getPasswordByEmail", name="app_password")
     */

    public function getPassswordByEmail(Request $request) {

        $email = $request->get('email');
        $user = $this->getDoctrine()->getManager()->getRepository(Utilisateur::class)->findOneBy(['email'=>$email]);
        if($user) {
            $password = $user->getPassword();
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($password);
            return new JsonResponse($formatted);
        }
        return new Response("user not found");




    }





}
