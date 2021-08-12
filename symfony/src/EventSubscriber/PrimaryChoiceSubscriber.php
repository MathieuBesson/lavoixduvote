<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RouterInterface;

class PrimaryChoiceSubscriber implements EventSubscriberInterface
{

    const PRIMARY_CHOICE_ID             = 'primaryChoice';
    const PRIMARY_CHOICE_PRESIDENTIAL   = '0';

    private RequestStack $requestStack;
    private RouterInterface $router;

    public function __construct(RequestStack $requestStack, RouterInterface $router)
    {
        $this->requestStack = $requestStack;
        $this->router = $router;
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
        // If he hasn't made his choice, and he is not on a route that will help him to make a choice, we redirect
        if (!isset($primaryChoice) && ($currentRoute !== 'primaries_index' && $currentRoute !== 'primarieschoiceprimary')) {
            $url = $this->router->generate('primaries_index');
            $event->setResponse(new RedirectResponse($url));
        }
    }
}