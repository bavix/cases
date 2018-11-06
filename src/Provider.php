<?php

namespace Bavix\Cases;

use Facebook\WebDriver\Remote\DesiredCapabilities;

interface Provider
{
    /**
     * Cap constructor.
     * @param Params $params
     */
    public function __construct(Params $params);

    /**
     * @return DesiredCapabilities
     */
    public function handle(): DesiredCapabilities;

    /**
     * @return string
     */
    public function serverUrl(): string;

    /**
     * @param RemoteWebDriver $driver
     * @return void
     */
    public function configure(RemoteWebDriver $driver);
}
