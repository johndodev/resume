<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Model\Contact;
use App\Repository\ResumeRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AppController extends Controller
{
    /**
     * @Route("/", name="home")
     * @Cache(maxage=15, smaxage=86400)
     */
    public function index(ResumeRepository $resumeRepository)
    {
        return $this->render('app/index.html.twig',  [
            'resume' => $resumeRepository->find(1),
        ]);
    }

    /**
     * @Route("contact", name="contact")
     */
    public function contactAction(Request $request, \Swift_Mailer $mailer)
    {
        // context
        //--------
        $messageSent   = false;
        $form           = $this->createForm(ContactType::class);

        // POST
        //------
        $form->handleRequest($request);

        if ($request->isMethod('post')) {
            // TODO service & refacto

            $postdata = http_build_query([
                'secret' => $this->getParameter('captcha.secret'),
                'response' => $request->request->get('g-recaptcha-response'),
                'remoteip' => $request->getClientIp()
            ]);

            $streamContext = stream_context_create([
                'http' => [
                    'method' => 'POST',
                    'content' => $postdata,
                    'header'  => 'Content-type: application/x-www-form-urlencoded',
                ]
            ]);

            $nocaptchaVerify = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $streamContext);
            $nocaptchaVerify = json_decode($nocaptchaVerify);

            if (!$nocaptchaVerify->success) {
                $form->addError(new FormError('Captcha error.'));
            }
        }

        if($form->isSubmitted() && $form->isValid()) {

            $messageSent = $this->sendContactMessage($form->getData(), $mailer);

            if($messageSent) {
                // remove datas
                $form = $this->createForm(ContactType::class);
            } else {
                $form->addError(new FormError('Oops, il semblerait que l\'envoie d\'e-mail ne fonctionne plus très bien. Essayez plutôt <b>jonathan.plantey@gmail.com</b> !'));
            }
        }

        // output
        //-------
        return $this->render('app/contact.html.twig', [
            'form'          => $form->createView(),
            'message_sent'  => $messageSent
        ]);
    }

    /**
     * Envoie le mail via swift
     * TODO move (dans form event ?)
     */
    private function sendContactMessage(Contact $form, \Swift_Mailer $mailer)
    {
        return $mailer->send((new \Swift_Message())
            ->setSubject('[jonathan-plantey.fr] '.$form->getSubject())
            ->setFrom($form->getEmail(), $form->getName())
            ->setReplyTo($form->getEmail(), $form->getName())
            ->setTo('jonathan.plantey@gmail.com')
            ->setBody($this->renderView('email/contact.html.twig', ['form' => $form]), 'text/html')
        );
    }
}
