<?php

class Util
{
    static function pre_r($data)
    {
        echo '<pre>';
        echo var_dump($data);
        echo '</pre>';
    }

    static function ifx(array $array, $key, $alternateReturn = null)
    {
        if (array_key_exists($key, $array)) {
            return $array[$key];
        }

        return $alternateReturn;
    }
}