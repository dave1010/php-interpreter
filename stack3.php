<?php

$stack = [];
$labels = [];
$pointer = 0;
$instructions = [];

/**
 * @param $stack
 * @param $instructions
 * @param $labels
 * @param $pointer
 */
function display($stack, $instructions, $labels, $pointer)
{
    echo "******************************************\n";
    echo "Stack: " . implode(', ', $stack) . "\n";
    echo "Instructions: " . implode(', ', $instructions) . "\n";
    echo "Labels: " . print_r($labels, true) . "\n";
    echo "Pointer: " . $pointer . "\n";
}

while(true) {
    usleep(300000);
    if (!array_key_exists($pointer, $instructions)) {
        $instructions[] = readline("> ");
    }

    $instruction = $instructions[$pointer];

    if (strpos($instruction, 'goto') === 0) {
        $label = explode(' ', $instruction)[1];
        $pointer = $labels[$label];
        continue;
    }

    if (strpos($instruction, 'jz') === 0) { // jump if zero
        $a = array_pop($stack);

        if (!$a) {
            $label = explode(' ', $instruction)[1];
            $pointer = $labels[$label];
        } else {
            $pointer++;
        }

        continue;


    }


    if ($instruction[0] === ':') {
        $labels[substr($instruction, 1)] = $pointer;
        array_pop($instructions);
        continue;
    }

    $pointer++;
    


    if (is_numeric($instruction)) {
        $stack[] = $instruction;
        continue;
    }



    switch ($instruction) {
        case '+';
            $a = array_pop($stack);
            $b = array_pop($stack);
            $stack[] = $a + $b;
            break;
        case '*';
            $a = array_pop($stack);
            $b = array_pop($stack);
            $stack[] = $a * $b;
            break;
        case '-';
            $a = array_pop($stack);
            $b = array_pop($stack);
            $stack[] = $b - $a;
            break;
        case '/';
            $a = array_pop($stack);
            $b = array_pop($stack);
            $stack[] = $b / $a;
            break;
        case '**';
            $a = array_pop($stack);
            $b = array_pop($stack);
            $stack[] = pow($b, $a);
            break;
        case '%';
            $a = array_pop($stack);
            $b = array_pop($stack);
            $stack[] = $b % $a;
            break;
        case '==';
            $a = array_pop($stack);
            $b = array_pop($stack);
            $stack[] = $b;
            //$stack[] = $a;
            $stack[] = (int) ($a == $b);
            break;
    }

    display($stack, $instructions, $labels, $pointer);


}
