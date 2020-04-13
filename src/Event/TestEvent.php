<?php


namespace App\Event;


use Doctrine\Common\EventArgs;
use Doctrine\Common\EventManager;

class TestEvent
{
    const preFoo = 'preFoo';

    public $preFooInvoked = false;
}