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
     * @Route(name="_index", path="/")
     */
    public function index(): Response
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
