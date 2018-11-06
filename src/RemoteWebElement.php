<?php

namespace Bavix\Cases;

use Facebook\WebDriver\Remote\DriverCommand;
use Facebook\WebDriver\WebDriverBy;

class RemoteWebElement extends \Facebook\WebDriver\Remote\RemoteWebElement
{

    /**
     * Find the first WebDriverElement within this element using the given mechanism.
     *
     * @param WebDriverBy $by
     * @return RemoteWebElement NoSuchElementException is thrown in
     *    HttpCommandExecutor if no element is found.
     * @see WebDriverBy
     */
    public function findElement(WebDriverBy $by)
    {
        $params = [
            'using' => $by->getMechanism(),
            'value' => $by->getValue(),
            ':id' => $this->id,
        ];
        $raw_element = $this->executor->execute(
            DriverCommand::FIND_CHILD_ELEMENT,
            $params
        );

        return $this->newElement(current($raw_element));
    }

    /**
     * Find all WebDriverElements within this element using the given mechanism.
     *
     * @param WebDriverBy $by
     * @return RemoteWebElement[] A list of all WebDriverElements, or an empty
     *    array if nothing matches
     * @see WebDriverBy
     */
    public function findElements(WebDriverBy $by)
    {
        $params = [
            'using' => $by->getMechanism(),
            'value' => $by->getValue(),
            ':id' => $this->id,
        ];
        $raw_elements = $this->executor->execute(
            DriverCommand::FIND_CHILD_ELEMENTS,
            $params
        );

        $elements = [];
        foreach ($raw_elements as $raw_element) {
            $elements[] = $this->newElement(current($raw_element));
        }

        return $elements;
    }

}
