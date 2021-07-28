<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
    function index() {
        return $this->render('candidate/candidate_index.html.twig');
    }
}