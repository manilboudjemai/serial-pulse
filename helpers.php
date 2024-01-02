<?php

if (! function_exists('dd')) {
    function dd(mixed $value, bool $die = false): void
    {
        echo '<pre>';
        var_dump($value);
        echo '</pre>';

        if ($die) {
            die();
            exit;
        }
    }
}

if (! function_exists('output')) {
    function output(mixed $value, bool $die = false): void
    {
        print_r($value);

        if ($die) {
            die();
            exit;
        }
    }
}
