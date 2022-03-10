<?php

namespace App\EventListener;

use App\Entity\Log;
use Doctrine\ORM\Events;
use Psr\Log\LoggerInterface;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;

class DoctrineSubscriber implements EventSubscriber
{
    private $dbLogger;

    public function __construct(LoggerInterface $dbLogger){
        $this->dbLogger = $dbLogger;
    }

    public function getSubscribedEvents()
    {
        return [
            Events::postPersist,
            Events::postUpdate,
            Events::postRemove
        ];
    }

    public function postPersist(LifecycleEventArgs $args){
        $this->log('ADD', $args);
        //  dd($args);
    }

    public function postUpdate(LifecycleEventArgs $args){
        $this->log('EDIT', $args);
        dd($args);

    }

    public function postRemove(LifecycleEventArgs $args){
        $this->log('REMOVE', $args);
        dd($args);
    }

    public function log($message, $arg){
        if (!($arg->getEntity() instanceof Log)){
            $this->dbLogger->info($message);
      }
    }

}