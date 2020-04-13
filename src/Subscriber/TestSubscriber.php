<?php


namespace App\Subscriber;


use App\Event\TestEvent;
use Doctrine\Common\EventSubscriber;

class TestSubscriber implements EventSubscriber
{

    /**
     * @inheritDoc
     */
    public function getSubscribedEvents()
    {
        return [
            TestEvent::preFoo
        ];
    }

    public function preFoo() {
        echo 'called from subscriber';
    }
}