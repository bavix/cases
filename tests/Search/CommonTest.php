<?php

namespace Tests\Search;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverKeys;
use Bavix\Cases\TestCase;

class CommonTest extends TestCase
{

    /**
     * @path /
     * @width 1366
     * @height 768
     * @dataProvider dataProvider
     *
     * @param string $input
     * @param string $expected
     */
    public function testMainPage($input, $expected)
    {
        $geoSearch = $this->driver
            ->findElement(WebDriverBy::id('geoSearch'))
            ->sendKeys($input);

        \sleep(1);

        try {
            $this->driver->getKeyboard()
                ->pressKey(WebDriverKeys::ENTER);
        } catch (\Throwable $throwable) {
            $this->driver->findElement(WebDriverBy::cssSelector('.GeoSearchWidget #ui-id-1 li a'))
                ->click();
        }

        \sleep(1);
        $this->assertEquals($expected, $geoSearch->getAttribute('value'));

        $this->driver->findElement(WebDriverBy::id('o_arrival'))
            ->click();

        $this->driver->findElement(WebDriverBy::className('calendar'))
            ->findElement(WebDriverBy::cssSelector('.available[data-title="r2c3"]'))
            ->click();

        $this->driver->findElements(WebDriverBy::className('calendar'))[2]
            ->findElement(WebDriverBy::cssSelector('.available[data-title="r3c2"]'))
            ->click();

        $this->driver->findElement(WebDriverBy::className('js-guestCountSelectMale-1'))
            ->click();

        $this->driver->executeScript('window.scrollTo(0, 200)');
        $this->driver->findElement(WebDriverBy::cssSelector('.btn--ok.js-guestCountDropdownListButtonClose'))
            ->click();

        $this->driver->findElement(WebDriverBy::id('entities-order-set-form'))
            ->submit();
    }

    /**
     * @path /city/Russia
     * @dataProvider dataProvider
     *
     * @param string $input
     * @param string $expected
     */
    public function testRussia($input, $expected)
    {
        $this->testMainPage($input, $expected);
    }

    /**
     * @return array
     */
    public function dataProvider(): array
    {
        /** [input, expected] */
        return [
            ['белый яр', 'Белый Яр'],
            ['краснодар', 'Краснодар'],
            ['москва', 'Москва'],
        ];
    }

}
