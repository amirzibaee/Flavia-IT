<?php

namespace Amirzibaee\DrinksMachine\Controllers;


/**
 * Class Machine
 * @package Amirzibaee\DrinksMachine\Controllers
 */
class Machine
{
    /**
     * @param string $drink
     * @param array $money_list
     * @return array|false
     */
    public function getDrink(string $drink, array $money_list)
    {
        $monies = new Monies;
        $drinks = new Drinks;

        if (!$monies->check($money_list)) {
            /** @TODO rolback */
            return false;
        }

        if (($price = $drinks->exist($drink)) === false) {
            /** @TODO rolback */
            return false;
        }

        $pay = $monies->plusMonies($money_list);


        $remaining = $monies->exchange($price, $pay);

        if ($remaining === false) {
            /** ROLBACK */
            $monies->minusMonies($money_list);
            return false;
        }

        $drinks->minusDrink($drink, 1);

        return $remaining;
    }
}