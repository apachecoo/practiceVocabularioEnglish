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
    if (existsCookie($nameCookie)) {
        $valueCookie = json_decode($_COOKIE[$nameCookie], true);
    }
    
    return $valueCookie;
}

function existsCookie(string $nameCookie): bool
{
    if (isset($_COOKIE[$nameCookie])) {
        return true;
    }

    return false;
}