<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class WhyVoteController
 * @package App\Controller
 *
 * @Route (name="why_vote", path="/pourquoi-voter")
 */
class WhyVoteController extends AbstractController
{
    /**
     * @Route("/", name="_index")
     */
    public function index(): Response
    {
        return $this->render('why_vote/why_vote_index.html.twig', [
            'controller_name' => 'WhyVoteController',
        ]);
    }
}
