<?php

namespace Knp\Rad\FixturesLoad;

use Symfony\Component\EventDispatcher\Event as BaseEvent;

class Event extends BaseEvent
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $file;

    /**
     * @var object[]
     */
    private $objects;

    /**
     * @param string $path
     * @param string $file
     */
    public function __construct($path, $file)
    {
        $this->path = $path;
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
     * @return string
     */
    public function getPath()
    {
        return $this->path;
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
