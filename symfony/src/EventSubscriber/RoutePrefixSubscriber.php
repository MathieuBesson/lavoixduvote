<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

class RoutePrefixSubscriber implements EventSubscriberInterface
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [
                ['getCurrentRoute', 10]
            ]
        ];
    }

    /**
     * @param RequestEvent $event
     *
     * Parse the route name and send the prefix (first item before _) as a twig global variable
     */
    public function getCurrentRoute(RequestEvent $event)
    {
        if (!$event->isMainRequest()) {
            return;
        }
        $request = $event->getRequest();
        $current_route = $request->attributes->get('_route');
        $route_prefix = explode('_', $current_route)[0];
        if (isset($route_prefix) && !empty($route_prefix)) {
            $this->twig->addGlobal('route_prefix', $route_prefix);
        }
    }
}