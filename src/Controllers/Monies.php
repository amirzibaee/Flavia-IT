<?php

namespace Amirzibaee\DrinksMachine\Controllers;

/**
 * Class Monies
 * @package Amirzibaee\DrinksMachine\Controllers
 */
class Monies
{
    private $monies = [
        '2' => 0,
        '1' => 0,
        '0.5' => 0,
        '0.2' => 0,
        '0.1' => 0,
    ];



    public function __construct()
    {
        $this->readDatabase();
    }

    public function __destruct()
    {
        $this->writeDatabase();
    }


    /**
     * read Database (Redis)
     *
     */
    private function readDatabase()
    {
        $monies = Database::get('monies');

        $this->monies = !empty($monies) ? unserialize($monies) : $this->monies;
    }

    /**
     *
     * update Redis
     */
    private function writeDatabase()
    {
        Database::set('monies', serialize($this->monies));
    }


    /**
     * @param array $pay
     * @return bool
     *
     */
    public function check(array $pay)
    {
        foreach ($pay as $money => $count) {
            if (!isset($this->monies[$money]))
                return false;
        }

        return true;
    }

    /**
     * @param $money
     * @param $count
     * @return false
     */
    public function plus($money, $count)
    {
        if (!isset($this->monies[$money])) {
            /** @TODO error */
            return false;
        }

        if ($count <= 0) {
            /** @TODO error */
            return false;
        }

        $this->monies[$money] += $count;

        $this->writeDatabase();
    }


    /**
     * @param $money
     * @param $count
     * @return false
     *
     */
    public function minus($money, $count)
    {
        if (!isset($this->monies[$money])) {
            /** @TODO error */
            return false;
        }

        if ($count <= 0) {
            /** @TODO error */
            return false;
        }

        if ($count > $this->monies[$money]) {
            /** @TODO error */
            return false;
        }

        $this->monies[$money] -= $count;

        $this->writeDatabase();
    }

    /**
     * @param $price
     * @param $pay
     * @return array|false
     *
     */
    public function exchange($price,  $pay)
    {
        if ($price <= 0 or $pay <= 0) {
            /** @TODO error */
            return false;
        }

        if (($pay * 100) % 10) {
            /** @TODO error */
            return false;
        }

        if ($price > $pay) {
            /** @TODO error */
            return false;
        }

        $remaining = $pay - $price;

        $output = [];

        if ($remaining == 0) {
            return $output;
        }

        foreach ($this->monies as $money => $count) {

            if ($count == 0)
                continue;

            if ($remaining == 0)
                break;

            $cnt_refund = (int) ($remaining / $money);

            if ($cnt_refund) {

                if ($count < $cnt_refund) {
                    $output[$money] = $count;
                } else {
                    $output[$money] = $cnt_refund;
                }

                $remaining -= $output[$money] * $money;
            }
        }

        if ($remaining) {
            /** @TODO error  bargashte pool */
            return false;
        }

        foreach ($output as $money => $count) {
            $this->minus($money, $count);
        }

        $this->writeDatabase();

        return $output;

    }


    /**
     * @param $money_list
     * @return float|int
     *
     */
    public function plusMonies($money_list)
    {
        $pay = 0;

        foreach ($money_list as $money => $value) {

            $this->plus($money, $value);

            $pay += $money * $value;
        }

        return $pay;
    }

    /**
     * @param $money_list
     *
     */
    public function minusMonies($money_list)
    {
        foreach ($money_list as $money => $value) {

            $this->minus($money, $value);
        }
    }
}