<?php


namespace Eheuje\PushoverBundle\Command;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputOption;

abstract class PushoverCommand extends ContainerAwareCommand
{
    const PUSHOVER_OPTION = 'with-pushover';

    /**
     * PushoverCommand constructor.
     * @param null|string $name
     */
    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->addOption(
            self::PUSHOVER_OPTION,
            null,
            InputOption::VALUE_NONE,
           'If set, display notifications over Pushover'
        );
        
    }
}