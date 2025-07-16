<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class PortfolioController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('portfolio/index.html.twig');
    }

    #[Route('/contact', name: 'app_contact', methods: ['GET', 'POST'])]
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            
            // Create email
            $email = (new Email())
                ->from('no-reply@cameleonne.fr')
                ->replyTo($data['email'])
                ->to('contact@cameleonne.fr')
                ->subject('Nouveau message depuis le portfolio - ' . $data['name'])
                ->html($this->renderView('emails/contact.html.twig', [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'message' => $data['message'],
                ]))
                ->text(sprintf(
                    "Nouveau message depuis le portfolio\n\nNom: %s\nEmail: %s\nMessage:\n%s",
                    $data['name'],
                    $data['email'],
                    $data['message']
                ));

            try {
                $mailer->send($email);
                $this->addFlash('success', 'Votre message a été envoyé avec succès !');
            } catch (\Exception $e) {
                // Log the actual error for debugging
                error_log('Email sending error: ' . $e->getMessage());
                
                // Show user-friendly error message
                $this->addFlash('error', 'Une erreur s\'est produite lors de l\'envoi du message. Veuillez réessayer.');
            }

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('portfolio/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/projet/ninie', name: 'app_projet_ninie')]
    public function projetNinie(): Response
    {
        return $this->render('portfolio/projet-ninie.html.twig');
    }

    #[Route('/projet/fdb', name: 'app_projet_fdb')]
    public function projetFdb(): Response
    {
        return $this->render('portfolio/projet-fdb.html.twig');
    }

    #[Route('/projet/fir', name: 'app_projet_fir')]
    public function projetFir(): Response
    {
        return $this->render('portfolio/projet-fir.html.twig');
    }

    #[Route('/projet/couvretout', name: 'app_projet_couvretout')]
    public function projetCouvretout(): Response
    {
        return $this->render('portfolio/projet-couvretout.html.twig');
    }
}