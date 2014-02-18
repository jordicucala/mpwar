<?php

include_once __DIR__ . '/../src/Money.php';


class MoneyTest extends PHPUnit_Framework_TestCase
{
    public function testCanBeNegated()
    {
        // Arrange
        $a = new Money(1);
        // Act
        $b = $a->negate();
        // Assert
        var_dump($b->getAmount());
        $this->assertEquals(-1, $b->getAmount());
    }
}