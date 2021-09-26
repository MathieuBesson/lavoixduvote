<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GlossaryController
 * @package App\Controller
 *
 * @Route (name="glossary", path="/glossaire")
 */
class GlossaryController extends AbstractController
{
    /**
     * @param string $search The search to look for, this is only for JS treatment
     * @Route(name="_index", path="/{search}")
     */
    public function index(string $search = ''): Response
    {
        $repository = $this->getDoctrine()->getRepository('App\Entity\GlossaryCategory');
        $glossaryCategories = $repository->findAll();

        $repository = $this->getDoctrine()->getRepository('App\Entity\Glossary');
        $definitions = $repository->findAll();

        return $this->render('glossary/glossary_index.html.twig', [
            'glossaryCategories' => $glossaryCategories,
            'definitions' => $definitions
        ]);
    }
}
