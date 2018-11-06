<?php

namespace Bavix\Cases;

class TestCase extends \PHPUnit\Framework\TestCase
{

    protected $providers = [
        'chrome' => Provider\ChromeProvider::class,
        'firefox' => Provider\GeckoProvider::class,
    ];

    /**
     * @var Params
     */
    protected $params;

    /**
     * @var RemoteWebDriver
     */
    protected $driver;

    /**
     * @return Provider
     */
    protected function caps(): Provider
    {
        $browser = $this->params->getBrowser();
        if (empty($this->providers[$browser])) {
            throw new \RuntimeException('Browser not supported');
        }

        $class = $this->providers[$browser];
        return new $class($this->params);
    }

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        $this->params = new Params($this->getAnnotations());
        $provider = $this->caps();
        $caps = $provider->handle();

        $this->driver = RemoteWebDriver::create($provider->serverUrl(), $caps);
        $this->driver->setBaseUrl($_ENV['BASE_URL']);
        $this->driver->get($this->params->getPath());
        $provider->configure($this->driver);
    }

    /**
     * This method is called after each test.
     */
    protected function tearDown()
    {
        try {
            $this->driver->close();
            $this->driver->quit();
        } catch (\Throwable $throwable) {

        }
    }

}
