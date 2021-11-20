<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GenericController
 * @package App\Controller
 */
class GenericController extends AbstractController
{
    /**
     * @Route(name="why_vote_index", path="/pourquoi-voter")
     */
    public function whyVotePage(): Response
    {
        return $this->render('generics/why_vote_index.html.twig', [
            'controller_name' => 'WhyVoteController',
        ]);
    }

    /**
     * @Route(name="what_are_presidentials_index", path="/c-est-quoi-les-presidentielles")
     */
    public function whatArePresidentialsPage(): Response
    {
        return $this->render('generics/what_are_presidentials.html.twig', [
            'controller_name' => 'whatArePresidentialsController',
        ]);
    }


	/**
	 * @Route(name="contact_index", path="/contact")
	 */
	public function contactPage(): Response
	{
		return $this->render('generics/contact.html.twig');
	}
}
