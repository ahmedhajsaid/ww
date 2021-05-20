<?php

namespace App\Controller;

use App\Form\ContactcompType;
use App\Form\CONTACTType;
use App\Form\ContactTypee;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request,\Swift_Mailer $mailer)
    {
        $form = $this->createForm(CONTACTType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();

            // Ici nous enverrons l'e-mail
            $message = (new \Swift_Message('Nouveau contact'))
                ->setFrom($contact['email'])
                ->setTo('punchymistake@mailinator.com')
                ->setBody(
                    $this->renderView(
                        'Emailscomp/contact.html.twig', compact('contact')
                    ),
                    'text/html'
                )
            ;
            $mailer->send($message);
            $this->addFlash('message', 'Votre message a été transmis, nous vous répondrons dans les meilleurs délais.'); // Permet un message flash de renvoi
        }
        return $this->render('contact/index.html.twig',['contactForm' => $form->createView()]);
    }
    /**
     * @Route("/contactUS", name="contactUS")
     */
    public function indexUS(Request $request,MailerInterface $mailer): \Symfony\Component\HttpFoundation\Response
    {  $form=$this->createForm(ContactTypee::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $contact=$form->getData();
            $email = (new Email())
                ->from($contact['email'])
                ->to('complexsportiftunis@gmail.com')

                ->subject('you have reach US !')
                ->text($contact['message']);


            $mailer->send($email);
            return $this->redirectToRoute('contactUS');
        }
        return $this->render('front/contactus.html.twig',[
            'form'=>$form->createView()
        ]);
    }

}