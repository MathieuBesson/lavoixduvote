<?php

namespace App\Controller;

use App\Entity\Candidate;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $candidates = $this->getDoctrine()
            ->getRepository(Candidate::class)
            ->findAll();

        return $this->render('home/home_index.html.twig', [
            'candidates' => $candidates,
        ]);
    }
}
