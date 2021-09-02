<?php

namespace App\Controller;

use App\Entity\Candidate;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ComparatorController
 * @package App\Controller
 *
 * @Route (name="comparator", path="/comparateur")
 */
class ComparatorController extends AbstractController
{
    /**
     * @Route(name="_index", path="/")
     */
    public function index(): Response
    {

        $repository = $this->getDoctrine()
            ->getRepository(Candidate::class);

        $candidates = $repository->getPresidentialCandidates();

        // Shuffle for objectivity
        shuffle($candidates);
        return $this->render('comparator/comparator_index.html.twig', [
            'candidates' => $candidates,
        ]);
    }
}
