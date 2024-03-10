<?php

function square_root($number)
{
    if ($number < 0) {
        throw new Exception("The given number is negative.");
    }

    return sqrt($number);
}

try {
    $number = 144;
    $squareRoot = square_root($number);
    echo "The square root of the number ($number) is: $squareRoot";
} catch (Exception $e) {
    echo $e->getMessage();
}