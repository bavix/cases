<?php

namespace Bavix\Cases\Provider;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverDimension;
use Bavix\Cases\Provider;
use Bavix\Cases\Params;
use Bavix\Cases\RemoteWebDriver;

class GeckoProvider implements Provider
{

    /**
     * @var Params
     */
    protected $params;

    /**
     * ChromeCap constructor.
     * @param Params $params
     */
    public function __construct(Params $params)
    {
        $this->params = $params;
    }

    /**
     * @return DesiredCapabilities
     */
    public function handle(): DesiredCapabilities
    {
        return DesiredCapabilities::firefox();
    }

    /**
     * @return string
     */
    public function serverUrl(): string
    {
        return $_ENV['GECKO_URL'];
    }

    /**
     * @param RemoteWebDriver $driver
     * @return void
     */
    public function configure(RemoteWebDriver $driver)
    {
        $dimension = new WebDriverDimension(
            $this->params->getWidth(),
            $this->params->getHeight()
        );

        $driver->manage()->window()->setSize($dimension);
    }

}
