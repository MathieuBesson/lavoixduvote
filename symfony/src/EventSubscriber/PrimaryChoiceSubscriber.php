<?php

namespace App\EventSubscriber;

use App\Entity\Primary;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

class PrimaryChoiceSubscriber implements EventSubscriberInterface
{

    const PRIMARY_CHOICE_ID = 'primaryChoice';
    const PRIMARY_CHOICE_PRESIDENTIAL = '0';

    private RequestStack $requestStack;
    private RouterInterface $router;
    private Environment $twig;
    private EntityManagerInterface $em;

    public function __construct(RequestStack $requestStack, RouterInterface $router, Environment $twig, EntityManagerInterface $em)
    {
        $this->requestStack = $requestStack;
        $this->router = $router;
        $this->twig = $twig;
        $this->em = $em;
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [
                ['doesUserHaveChosen', 20]
            ]
        ];
    }

    /**
     * If the user has not chosen any primary nor presidential
     * We redirect him, because he must choose.
     *
     * @param RequestEvent $event
     */
    public function doesUserHaveChosen(RequestEvent $event)
    {
        if (!$event->isMainRequest()) {
            return;
        }
        $session = $this->requestStack->getSession();
        $primaryChoice = $session->get(self::PRIMARY_CHOICE_ID);
        $currentRoute = $event->getRequest()->attributes->get('_route');

        if ($currentRoute === 'home') {
            // If he hasn't made his choice, and he is not on a route that will help him to make a choice, we redirect
            if (!isset($primaryChoice) && ($currentRoute !== 'primaries_index' && $currentRoute !== 'primarieschoiceprimary')) {
                $url = $this->router->generate('primaries_index');
                $event->setResponse(new RedirectResponse($url));
            } elseif (isset($primaryChoice)) {
                if ($primaryChoice !== self::PRIMARY_CHOICE_PRESIDENTIAL) {
                    $primary = $this->em->getRepository(Primary::class)
                        ->find($primaryChoice);
                    $name = 'Primaire ' . $primary->getPoliticalParty()->getAcronym();
                } else {
                    $name = 'Présidentielles 2022';
                }
                $this->twig->addGlobal(self::PRIMARY_CHOICE_ID, $name);
            }
        }
    }
}