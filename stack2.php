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

    if (empty($instructions[$pointer])) {
        $instructions[] = readline("> ");
    }

    $instruction = $instructions[$pointer];

    if (strpos($instruction, 'goto') === 0) {
        $label = explode(' ', $instruction)[1];
        $pointer = $labels[$label];
        continue;
    }

    $pointer++;


    if ($instruction[0] === ':') {
        $labels[substr($instruction, 1)] = $pointer;
    }

    if (is_numeric($instruction)) {
        $stack[] = $instruction;
        continue;
    }


    $a = array_pop($stack);
    $b = array_pop($stack);

    switch ($instruction) {
        case '+';
            $stack[] = $a + $b;
            break;
        case '*';
            $stack[] = $a * $b;
            break;
        case '-';
            $stack[] = $a - $b;
            break;
        case '/';
            $stack[] = $a / $b;
            break;
        case '**';
            $stack[] = pow($a, $b);
            break;
        case '%';
            $stack[] = $a % $b;
            break;
    }

    display($stack, $instructions, $labels, $pointer);


}
