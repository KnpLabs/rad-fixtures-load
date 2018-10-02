<?php

declare(strict_types=1);

namespace Knp\Rad\FixturesLoad\Formater;

use Knp\Rad\FixturesLoad\Event;
use Knp\Rad\FixturesLoad\Formater;
use Symfony\Component\Console\Output\OutputInterface;

class BundleFormater implements Formater
{
    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @var string[]
     */
    private $cache = [];

    /**
     * {@inheritdoc}
     */
    public function setOutput(OutputInterface $output)
    {
        $this->output = $output;
    }

    /**
     * {@inheritdoc}
     */
    public function getVerbosity(): bool
    {
        return self::VERBOSITY_NORMAL;
    }

    /**
     * {@inheritdoc}
     */
    public function preLoad(Event $event)
    {
        $class = \get_class($event->getBundle());

        if (\in_array($class, $this->cache)) {
            return;
        }

        $this->output->writeln(sprintf('<fg=black;bg=green>#Bundle > %s </fg=black;bg=green>', $class));
        $this->cache[] = $class;
    }

    /**
     * {@inheritdoc}
     */
    public function postLoad(Event $event)
    {
    }
}
