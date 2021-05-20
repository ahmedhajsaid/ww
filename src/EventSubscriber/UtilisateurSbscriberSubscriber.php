<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UtilisateurSbscriberSubscriber implements EventSubscriberInterface
{
    public function onY($event)
    {
        // ...
    }

    public static function getSubscribedEvents()
    {
        return [
            'y' => 'onY',
        ];
    }
}
