<?php

namespace Bavix\Cases;

/**
 * Class Params
 * @package Bavix\Cases
 */
class Params
{

    /**
     * @var array
     */
    protected $annotations;

    /**
     * Params constructor.
     * @param array $annotations
     */
    public function __construct(array $annotations)
    {
        $this->annotations = $annotations;
    }

    /**
     * @param string $name
     * @param array $default
     * @return array
     */
    protected function getAttribute(string $name, array $default = []): array
    {
        return $this->annotations['method'][$name] ?? $default;
    }

    /**
     * @param string $name
     * @param int $default
     * @return int
     */
    protected function getInt(string $name, int $default = 0): int
    {
        return \current($this->getAttribute($name, [$default]));
    }

    /**
     * @param string $name
     * @param string $default
     * @return string
     */
    protected function getString(string $name, string $default): string
    {
        return \current($this->getAttribute($name, [$default]));
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->getInt('width', 1024);
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->getInt('height', 768);
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->getString('path', '/');
    }

    /**
     * @return string
     */
    public function getBrowser(): string
    {
        return $this->getString('browser', $_ENV['BROWSER']);
    }

}
