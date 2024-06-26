<?php

function dd(mixed $mixed){
    echo "<pre>";
    print_r($mixed);
    echo "</pre>";
    exit();
}

function dump(mixed $mixed){
    echo "<pre>";
    print_r($mixed);
    echo "</pre>";
}