<?php


namespace App\Listener;


use Doctrine\Common\EventArgs;

class TestListener
{
    public function preFoo(?EventArgs $eventArgs) {
        echo 'pre foo called with ' . print_r($eventArgs);
    }
}