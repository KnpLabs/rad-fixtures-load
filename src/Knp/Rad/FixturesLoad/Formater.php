<?php

namespace Knp\Rad\FixturesLoad;

use Symfony\Component\Console\Output\OutputInterface;

interface Formater
{
    const VERBOSITY_NORMAL = false;

    const VERBOSITY_EXTRA  = true;

    /**
     * @param OutputInterface $output
     *
     * @return Formater
     */
    public function setOutput(OutputInterface $output);

    /**
     * @return boolean
     */
    public function getVerbosity();

    /**
     * @param Event $event
     *
     * @return Formater
     */
    public function preLoad(Event $event);

    /**
     * @param Event $event
     *
     * @return Formater
     */
    public function postLoad(Event $event);
}
