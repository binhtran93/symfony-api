<?php

namespace App\Controller;

use App\Event\TestEvent;
use App\Listener\TestListener;
use App\Subscriber\TestSubscriber;
use Doctrine\Common\EventArgs;
use Doctrine\Common\EventManager;
use Doctrine\ORM\Events;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    /**
     * @Route("/test-event")
     */
    public function test() {
        $evm = new EventManager();
//        $evm->addEventListener(TestEvent::preFoo, new TestListener());
//        $eventArgs = new EventArgs();
//        $eventArgs->params = [1,2,3];
//        $evm->dispatchEvent(TestEvent::preFoo, $eventArgs);
        Events::onFlush;
        $subscriber = new TestSubscriber();
        $evm->addEventSubscriber($subscriber);
        $evm->dispatchEvent(TestEvent::preFoo);

        return $this->json([]);
    }
}
