<?php


namespace App\Controller;


use App\Entity\Candidate;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CandidateController
 * @package App\Controller
 *
 * @Route (name="candidates", path="/candidats")
 */
class CandidateController extends AbstractController
{
    /**
     * @Route(name="_index", path="/")
     */
    public function index() {
        return $this->render('candidate/candidate_index.html.twig');
    }

    /**
     * @Route(name="_list_name", path="/list-name")
     */
    public function listCandidatesName(): Response
    {
        $candidates = $this->getDoctrine()
            ->getRepository(Candidate::class)
            ->findAllNames();

        return $this->render('candidate/candidate_list_names.html.twig', [
            'candidates' => $candidates
        ]);
    }
}