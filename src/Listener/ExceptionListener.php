<?php
/**
 * Created by PhpStorm.
 * User: binh
 * Date: 09/04/2020
 * Time: 13:41
 */

namespace App\Listener;


use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{
    public function  onKernelException(ExceptionEvent $event) {
        dd(1);
    }
}