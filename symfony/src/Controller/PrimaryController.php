<?php

namespace App\Controller;

use App\Entity\Candidate;
use App\Entity\Primary;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PrimaryController
 * @package App\Controller
 *
 * @Route (name="primaries", path="/primaires")
 */
class PrimaryController extends AbstractController
{
    /**
     * @Route(name="_list_name", path="/list-name")
     */
    public function listPrimariesName(): Response
    {
        $primaries = $this->getDoctrine()
            ->getRepository(Primary::class)
            ->getCurrentPrimaries();

        return $this->render('primary/primary_list_name.html.twig', [
            'primaries' => $primaries
        ]);
    }

    /**
     * @Route(name="choiceprimary", path="/selection/{primaryId}")
     */
    public function choicePrimary($primaryId, RequestStack $requestStack)
    {
        $session = $requestStack->getSession();
        if ($primaryId === 0) {
            $session->remove('primaryChoice');
        } else {
            $session->set('primaryChoice', $primaryId);
        }

        return $this->redirectToRoute('home');
    }
}