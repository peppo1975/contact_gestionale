<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function inverse($x) {
    if (!$x) {
        throw new Exception('Division by zero.');
    }
    return 1/$x;
}


echo inverse(0) . "\n";

try {
    echo inverse(5) . "\n";
    echo inverse(0) . "\n";
    echo inverse(0) . "\n";
    echo inverse(0) . "\n";
    echo inverse(0) . "\n";
    echo inverse(0) . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

// Continue execution
echo "Hello World\n";