<?php

//require_once __DIR__ . '\..\vendor\autoload.php';

use PHPUnit\Framework\TestCase;

use Amirzibaee\DrinksMachine\Controllers\Database;
use Amirzibaee\DrinksMachine\Controllers\Monies;
use Amirzibaee\DrinksMachine\Controllers\Drinks;

final class MoniesTest extends TestCase
{

    protected $monies;

    /**
     * Call this template method before each test method is run.
     */
    protected function setUp(): void
    {
        Database::connect();
        $this->monies = new Monies;
        $this->monies->plusMonies(
            [
                '2' => 10,
                '1' => 10,
                '0.5' => 10,
                '0.2' => 10,
                '0.1' => 10,
            ]
        );

        $drinks = new Drinks;

        $drinks->addContainer('pepsi', 'Pepsi', 10, 1);
        $drinks->addContainer('fanta', 'Fanta',10, 2);
    }

    public function testCheck(): void
    {
        $this->assertEquals(
            true,
            $this->monies->check([
                '2' => 1,
                '1' => 10,
                '0.1' => 3,
                '0.2' => 3,
                '0.5' => 3,
            ])
        );

        $this->assertEquals(
            false,
            $this->monies->check([
                '2' => 1,
                '1' => 10,
                '0.1' => 3,
                '3' => 3,
                '0.5' => 3,
            ])
        );
    }

    public function testExchange(): void
    {
        $this->assertEquals(
            false,
            $this->monies->exchange(2, 3.25)
        );

        $this->assertEquals(
            false,
            $this->monies->exchange(10, 9)
        );

        $this->assertEquals(
            ['2' => 3, '1' => 1],
            $this->monies->exchange(2, 9)
        );


        /**
         * this test is a fail
         *  Because the coding was not complete
         *
         */
        $this->assertEquals(
            ['2' => 3, '1' => 1, '0.5' => 1, '0.2' => 1, '0.1' => 1],
            $this->monies->exchange(2, 9.8)
        );
    }
}





