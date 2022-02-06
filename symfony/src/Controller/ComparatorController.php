<?php

namespace App\Controller;

use App\Entity\Candidate;
use App\Entity\Theme;
use App\Entity\Program;
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
        $candidatesRepository = $this->getDoctrine()
            ->getRepository(Candidate::class);

        $candidatesPresidential = $candidatesRepository->getPresidentialCandidatesWithProgram();
		shuffle($candidatesPresidential);

        $themesRepository = $this->getDoctrine()
            ->getRepository(Theme::class);

        $themesNames = $themesRepository->findAll();

        $candidatesActionsByTheme = $candidatesRepository->getAllWithProgramPartyActionsAndTheme();
        
        return $this->render('comparator/comparator_index.html.twig', [
            'candidatesPresidential' => $candidatesPresidential,
            'themesNames' => $themesNames,
            'candidatesActionsByTheme' => $candidatesActionsByTheme
        ]);
    }
}
