<?php

namespace App\Controller;

use App\Entity\Candidate;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SitemapController extends AbstractController
{
	/**
	 * @Route("/sitemap.xml", name="sitemap", defaults={"_format"="xml"})
	 */
	public function index(Request $request)
	{
		// Nous récupérons le nom d'hôte depuis l'URL
		$hostname = $request->getSchemeAndHttpHost();

		// On initialise un tableau pour lister les URLs
		$urls = [];

		// On ajoute les URLs "statiques"
		$urls[] = ['loc' => $this->generateUrl('candidates_index')];
		$urls[] = ['loc' => $this->generateUrl('what_are_presidentials_index')];
		$urls[] = ['loc' => $this->generateUrl('contact_index')];
		$urls[] = ['loc' => $this->generateUrl('privacy_policy_index')];
		$urls[] = ['loc' => $this->generateUrl('glossary_index')];
		$urls[] = ['loc' => $this->generateUrl('home')];

		// On ajoute les URLs dynamiques des articles dans le tableau
		/** @var Candidate $candidate */
		foreach ($this->getDoctrine()->getRepository(Candidate::class)->findAll() as $candidate) {
			$images = [
				'loc'   => '/uploads/candidates/' . $candidate->getPicture(), // URL to image
				'title' => $candidate->getFirstName()    // Optional, text describing the image
			];

			$urls[] = [
				'loc'     => $this->generateUrl('candidates_show', [
					'candidate' => $candidate->getFirstName(),
				]),
				'image'   => $images,
			];
		}

		// Fabrication de la réponse XML
		$response = new Response(
			$this->renderView('sitemap/index.html.twig', [
				'urls'     => $urls,
				'hostname' => $hostname,
			]),
		);


		// Ajout des entêtes
		$response->headers->set('Content-Type', 'text/xml');

		// On envoie la réponse
		return $response;
	}
}
