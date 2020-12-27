<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="app_contact")
     * @param Request $request
     *
     * @param \Swift_Mailer $mailer
     * @return RedirectResponse|Response
     */
    function new (Request $request, \Swift_Mailer $mailer)
    {
        $contact = new Contact;
        $form = $this->createForm(ContactType::class);

        return $this->handleForm($contact, $form, $request, $mailer);
    }

    /**
     * @param Contact $contact
     * @param FormInterface $formInterface
     * @param Request $request
     *
     * @param \Swift_Mailer $mailer
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    private function handleForm(Contact $contact, FormInterface $formInterface, Request $request, \Swift_Mailer $mailer)
    {
        // Handle form
        $formInterface->handleRequest($request);

        if ($formInterface->isSubmitted()) {
            if ($formInterface->isValid()) {

                $contact = $formInterface->getData();

                $message = (new \Swift_Message('Email vom Kontakt formular - habits'))
                    ->setFrom($contact->getEmail())
                    ->setTo('mklit87@gmail.com')
                    ->setBody(
                        $this->renderView(
                        // templates/emails/registration.html.twig
                            'contact/email.html.twig',
                            [
                                'email' => $contact->getEmail(),
                                'message' => $contact->getMessage(),
                                'name' => $contact->getName()
                            ]
                        ),
                        'text/html'
                    );

                $mailer->send($message);

                return $this->redirect($this->generateUrl('app_contact'));
            }
            //$this->addFlashMessage('error', '');
        }

        return $this->render('contact/index.html.twig', [
            'navi' => 'contact',
            'form' => $formInterface->createView(),
            'goal' => $contact,
        ]);
    }
}
