<?php

namespace App\Controller;

use App\Entity\Candidate;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(RequestStack $requestStack): Response
    {
        $session = $requestStack->getSession();
        $repository = $this->getDoctrine()
            ->getRepository(Candidate::class);
        if ($primaryId = $session->get('primaryChoice')) {
            $candidates = $repository->getCandidatesByPrimaries($primaryId);
        } else {
            $candidates = $repository->getPresidentialCandidates();
        }

        return $this->render('home/home_index.html.twig', [
            'candidates' => $candidates,
        ]);
    }
}
