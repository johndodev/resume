<?php

namespace App\Controller;

use App\Repository\ResumeRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @Cache(maxage=15, smaxage=86400)
     */
    public function index(ResumeRepository $resumeRepository): Response
    {
        return $this->render('app/index.html.twig',  [
            'resume' => $resumeRepository->find(1),
        ]);
    }
}
