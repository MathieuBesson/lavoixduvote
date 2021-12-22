<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\FaqRepository;
use App\Repository\FaqThemeRepository;

/**
 * Class GenericController
 * @package App\Controller
 */
class GenericController extends AbstractController
{
    /**
     * @Route(name="what_are_presidentials_index", path="/c-est-quoi-les-presidentielles")
     */
    public function whatArePresidentialsPage(FaqRepository $faqRepository, FaqThemeRepository $faqThemeRepository): Response
    {
        return $this->render('generics/what_are_presidentials.html.twig', [
            'controller_name' => 'whatArePresidentialsController',
            'explanations' => $faqRepository->findAll(),
            'navList' => $faqThemeRepository->findAll()
        ]);
    }


	/**
	 * @Route(name="contact_index", path="/contact")
	 */
	public function contactPage(): Response
	{
		return $this->render('generics/contact.html.twig');
	}

    /**
	 * @Route(name="privacy_policy", path="/politique-de-confidentialite")
	 */
	public function privacyPolicy(): Response
	{
		return $this->render('generics/privacy_policy.html.twig');
	}
}
