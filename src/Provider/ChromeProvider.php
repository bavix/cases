<?php

namespace Bavix\Cases\Provider;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Bavix\Cases\Provider;
use Bavix\Cases\Params;
use Bavix\Cases\RemoteWebDriver;

class ChromeProvider implements Provider
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
        $options = new ChromeOptions();
        $options->addArguments([
            \sprintf('--window-size=%d,%d', $this->params->getWidth(), $this->params->getHeight())
        ]);

        $caps = DesiredCapabilities::chrome();
        $caps->setCapability(ChromeOptions::CAPABILITY, $options);

        return $caps;
    }

    /**
     * @return string
     */
    public function serverUrl(): string
    {
        return $_ENV['CHROME_URL'];
    }

    /**
     * @param RemoteWebDriver $driver
     * @return void
     */
    public function configure(RemoteWebDriver $driver)
    {

    }

}
