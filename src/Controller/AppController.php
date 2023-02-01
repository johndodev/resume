<?php

namespace App\Controller;

use App\Repository\ResumeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ResumeRepository $resumeRepository): Response
    {
        return $this->render('app/index.html.twig', [
            'resume' => $resumeRepository->findOneBy([]),
        ]);
    }
}
