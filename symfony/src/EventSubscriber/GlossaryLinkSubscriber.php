<?php

namespace App\EventSubscriber;

use App\Entity\Glossary;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Matcher\UrlMatcher;

class GlossaryLinkSubscriber implements EventSubscriberInterface
{
    private EntityManagerInterface $em;
    private UrlGeneratorInterface $router;


    public function __construct(EntityManagerInterface $em, UrlGeneratorInterface $router)
    {
        $this->em = $em;
        $this->router = $router;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => [
                ['updateTemplateWithGlossaryLink', 10]
            ]
        ];
    }

    /**
     * Check for entries in the glossary table, and dynamically change the template with a link to the glossary page
     * of a word is matched
     *
     * @param ResponseEvent $event
     */
    public function updateTemplateWithGlossaryLink(ResponseEvent $event)
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $response = $event->getResponse();
        $content = $response->getContent();
        $context = $this->router->getContext();
        $parsedUrl = parse_url($context->getPathInfo());

        $matcher = new UrlMatcher(
            $this->router->getRouteCollection(),
            $context
        );

        $routeInfo = $matcher->match($parsedUrl['path']);
        $routeName = $routeInfo['_route'];

        if (!in_array($routeName, ['comparator_index', 'candidates_show'])) {
            return;
        }
        $glossaryWords = $this->em->getRepository(Glossary::class)->findAll();

        foreach ($glossaryWords as $glossaryWord) {
            $word = $glossaryWord->getWord();
            $glossaryPageUrl = $this->router->generate('glossary_index', [ 'search' => rawurlencode($word) ]);
            // Regex exact match with boundary word \b
            if (preg_match('/\b' . $word . '\b/i', $content) === 1) {
                // Use preg_replace with $0 in order to display the original matched word.
                // e.g. if the word matched is "prépas", and the glossary word is "Prépas", the link will lead to
                // the "Prépas" entry in glossary, but it will still be displayed as "prépas" on the original page
                $content = preg_replace('/\b' . $word . '\b/i', '<a href="' . $glossaryPageUrl . '">$0</a>', $content);
            }
        }

        $response->setContent($content);
    }
}