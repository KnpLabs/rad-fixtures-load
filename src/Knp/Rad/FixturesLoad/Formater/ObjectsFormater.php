<?php

declare(strict_types=1);

namespace Knp\Rad\FixturesLoad\Formater;

use Knp\Rad\FixturesLoad\Event;
use Knp\Rad\FixturesLoad\Formater;
use Symfony\Component\Console\Output\OutputInterface;

class ObjectsFormater implements Formater
{
    /**
     * @var OutputInterface
     */
    private $output;

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
        return self::VERBOSITY_EXTRA;
    }

    /**
     * {@inheritdoc}
     */
    public function preLoad(Event $event)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function postLoad(Event $event)
    {
        $entities = [];

        foreach ($event->getObjects() as $object) {
            $class = \get_class($object);
            if (false === array_key_exists($class, $entities)) {
                $entities[$class] = [];
            }
            $entities[$class][] = $object;
        }

        foreach ($entities as $class => $instances) {
            $this->output->writeln(sprintf('        <comment>%s</comment>: %s', $class, \count($instances)));
        }
    }
}
