<?php


namespace Eheuje\PushoverBundle\Listener;

use Eheuje\PushoverBundle\Command\PushoverCommand;
use Eheuje\PushoverBundle\Service\Pushover;
use Symfony\Component\Stopwatch\Stopwatch;

abstract class PushoverListener
{
    /**
     * @var Pushover
     */
    protected $pushover;

    /**
     * @var Stopwatch
     */
    protected $stopwatch;

    /**
     * @var boolean
     */
    protected $isActivate;

    /**
     * @param boolean $isActivate
     */
    public function setIsActivate($isActivate)
    {
        $this->isActivate = $isActivate;
    }

    /**
     * PushoverListener constructor.
     * @param Pushover $pushover
     * @param $stopwatch
     */
    public function __construct($pushover, $stopwatch)
    {
        $this->pushover = $pushover;
        $this->stopwatch = $stopwatch;
    }
}