<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

class FakeDataDisclaimerSubscriber implements EventSubscriberInterface
{
    const NOTIFICATION_SEEN_ID = 'notificationSeen';

    private RequestStack $requestStack;
    private Environment $twig;

    public function __construct(RequestStack $requestStack, Environment $twig)
    {
        $this->requestStack = $requestStack;
        $this->twig = $twig;
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [
                ['doesUserHaveSeenPopUp', 20]
            ]
        ];
    }

    /**
     * Display or not disclaimer popup for fake data
     */
    public function doesUserHaveSeenPopUp()
    {
        $session = $this->requestStack->getSession();
        $this->twig->addGlobal(self::NOTIFICATION_SEEN_ID, $session->get(self::NOTIFICATION_SEEN_ID));
    }
}
