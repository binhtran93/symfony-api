<?php


namespace App\Listener;


use App\Entity\Song;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;

class UserListener
{
    /**
     * @param Song $song
     * @param LifecycleEventArgs $args
     */
    public function prePersist(Song $song, LifecycleEventArgs $args) {
        echo 'entity listener called';
    }
}