<?php

namespace Bavix\Cases;

use Facebook\WebDriver\Remote\DriverCommand;
use Facebook\WebDriver\WebDriverBy;

class RemoteWebDriver extends \Facebook\WebDriver\Remote\RemoteWebDriver
{

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @param string $baseUrl
     * @return RemoteWebDriver
     */
    public function setBaseUrl(string $baseUrl): self
    {
        $this->baseUrl = $baseUrl;
        return $this;
    }

    /**
     * @param string $url
     * @return self
     */
    public function get($url): self
    {
        return parent::get($this->baseUrl . $url);
    }

    /**
     * Return the WebDriverElement with the given id.
     *
     * @param string $id The id of the element to be created.
     * @return RemoteWebElement
     */
    protected function newElement($id)
    {
        return new RemoteWebElement($this->getExecuteMethod(), $id);
    }

    /**
     * Find the first WebDriverElement using the given mechanism.
     *
     * @param WebDriverBy $by
     * @return RemoteWebElement NoSuchElementException is thrown in HttpCommandExecutor if no element is found.
     * @see WebDriverBy
     */
    public function findElement(WebDriverBy $by)
    {
        $params = ['using' => $by->getMechanism(), 'value' => $by->getValue()];
        $raw_element = $this->execute(
            DriverCommand::FIND_ELEMENT,
            $params
        );

        return $this->newElement(current($raw_element));
    }

    /**
     * Find all WebDriverElements within the current page using the given mechanism.
     *
     * @param WebDriverBy $by
     * @return RemoteWebElement[] A list of all WebDriverElements, or an empty array if nothing matches
     * @see WebDriverBy
     */
    public function findElements(WebDriverBy $by): array
    {
        $params = ['using' => $by->getMechanism(), 'value' => $by->getValue()];
        $raw_elements = $this->execute(
            DriverCommand::FIND_ELEMENTS,
            $params
        );

        $elements = [];
        foreach ($raw_elements as $raw_element) {
            $elements[] = $this->newElement(current($raw_element));
        }

        return $elements;
    }

}
