<?php

function dd(mixed $mixed): void
{
    echo "<pre>";
    print_r($mixed);
    echo "</pre>";
    exit();
}

function dump(mixed $mixed): void
{
    echo "<pre>";
    print_r($mixed);
    echo "</pre>";
}

function getCookie(string $nameCookie): ?array
{
    $valueCookie = null;
    if (isset($_COOKIE[$nameCookie])) {
        $valueCookie = json_decode($_COOKIE[$nameCookie], true);
    }
    return $valueCookie;
}
