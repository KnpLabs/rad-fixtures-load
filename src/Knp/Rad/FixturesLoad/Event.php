<?php

namespace Knp\Rad\FixturesLoad;

use Symfony\Component\EventDispatcher\Event as BaseEvent;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class Event extends BaseEvent
{
    /**
     * @var Bundle
     */
    private $bundle;

    /**
     * @var string
     */
    private $file;

    /**
     * @var object[]
     */
    private $objects;

    /**
     * @param Bundle $bundle
     * @param string $file
     */
    public function __construct(Bundle $bundle, $file)
    {
        $this->bundle = $bundle;
        $this->file   = $file;
    }

    /**
     * @param object[] $objects
     *
     * @return event
     */
    public function setObjects(array $objects)
    {
        $this->objects = $objects;

        return $this;
    }

    /**
     * @return Bundle
     */
    public function getBundle()
    {
        return $this->bundle;
    }

    /**
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @return object[]
     */
    public function getObjects()
    {
        return $this->objects;
    }
}
