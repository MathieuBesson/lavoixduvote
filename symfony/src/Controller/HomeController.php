<?php

namespace App\Controller;

use App\Entity\Candidate;
use App\EventSubscriber\PrimaryChoiceSubscriber;
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
        // If we have a primary choice, let's adapt our doctrine request !
        $primaryId = $session->get(PrimaryChoiceSubscriber::PRIMARY_CHOICE_ID);
        // 0 is for presidential choice
        if ($primaryId !== PrimaryChoiceSubscriber::PRIMARY_CHOICE_PRESIDENTIAL) {
            $candidates = $repository->getCandidatesByPrimaries($primaryId);
        } else {
            // If we have no session variable, it's the default choice : the great presidential
            $candidates = $repository->getPresidentialCandidates();
        }
		// Shuffle for objectivity
	    shuffle($candidates);
        return $this->render('home/home_index.html.twig', [
            'candidates' => $candidates,
        ]);
    }
}
