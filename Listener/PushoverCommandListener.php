<?php

namespace Eheuje\PushoverBundle\Listener;

use Eheuje\PushoverBundle\Command\PushoverCommandInterface;
use Eheuje\PushoverBundle\Service\Pushover;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Event\ConsoleExceptionEvent;
use Symfony\Component\Console\Event\ConsoleTerminateEvent;

class PushoverCommandListener extends PushoverListener
{
    /**
     * @param ConsoleCommandEvent $event
     */
    public function onCommandConsoleEvents(ConsoleCommandEvent $event)
    {
        $command = $event->getCommand();
        if ($command instanceof PushoverCommandInterface) {
            $this->stopwatch->start($event->getCommand()->getName());
            $this
                ->pushover
                ->setOption(Pushover::OPTION_TITLE, "Command {$command->getName()}");
        }
    }

    /**
     * @param ConsoleExceptionEvent $event
     */
    public function onExceptionConsoleEvents(ConsoleExceptionEvent $event)
    {
        $command = $event->getCommand();
        if ($command instanceof PushoverCommandInterface) {
            $stopwatchEvent = $this->stopwatch->stop($event->getCommand()->getName());
            $this
                ->pushover
                ->setMessage("Command {$command->getName()} thrown the following exception '{$event->getException()->getMessage()}'")
                ->setStopwatchEvent($stopwatchEvent)
                ->push();
        }
    }

    /**
     * @param ConsoleTerminateEvent $event
     */
    public function onTerminateConsoleEvents(ConsoleTerminateEvent $event) 
    {
        $command = $event->getCommand();
        if ($command instanceof PushoverCommandInterface && $this->stopwatch->isStarted($event->getCommand()->getName())) {
            $stopwatchEvent = $this->stopwatch->stop($event->getCommand()->getName());
            $this
                ->pushover
                ->setMessage("Command {$command->getName()} terminated with the exit code {$event->getExitCode()}")
                ->setStopwatchEvent($stopwatchEvent)
                ->push();
        }
    }
}