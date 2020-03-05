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
function display($stack, $instructions, $labels, $pointer, $registers)
{
    echo "******************************************\n";
    echo "Stack: " . implode(', ', $stack) . "\n";
    echo "Instructions: " . implode(', ', $instructions) . "\n";
    echo "Instruction: " . $instructions[$pointer - 1] . "\n";
    echo "Labels: " . print_r($labels, true) . "\n";
    echo "Registers: " . print_r($registers, true) . "\n";
}

$instructions = [
    "2",
    "3",
    "+",
];

$instructions = [
    "10",
    ":start",
    "1",
    "-",
    "0",
    "==",
    "jz start",
];

$registers = [];

// what is the lowest prime factor of 25?
$instructions = "1
1
:start
pop
1
+
push
25
swp
%
0
==
jz start
pop
";

$instructions = "4
stor A
7
7
7
7
7
10
ret A
+";

$instructions = explode("\n", $instructions);

foreach ($instructions as $k => $instruction) {
    if ($instruction && $instruction[0] === ':') {
        $labels[substr($instruction, 1)] = $k + 1;
    }
}

while(true) {
//    usleep(100000);

    display($stack, $instructions, $labels, $pointer, $registers);

    if (!array_key_exists($pointer, $instructions)) {
        break;
    }

    $instruction = $instructions[$pointer];

    if (strpos($instruction, 'stor') === 0) {
        $a = array_pop($stack);
        $register = explode(' ', $instruction)[1][0];
        $registers[$register] = $a;

        $pointer++;
        continue;
    }

    if (strpos($instruction, 'ret') === 0) {
        $register = explode(' ', $instruction)[1][0];
        $stack[] = $registers[$register];

        $pointer++;
        continue;
    }


    if (strpos($instruction, 'swp') === 0) {
        $a = array_pop($stack);
        $b = array_pop($stack);
        $stack[] = $a;
        $stack[] = $b;
        $pointer++;
        continue;
    }

    if (strpos($instruction, 'pop') === 0) {
        array_pop($stack);
        $pointer++;
        continue;
    }

    if (strpos($instruction, 'push') === 0) {
        $a = array_pop($stack);
        $stack[] = $a;
        $stack[] = $a;
        $pointer++;
        continue;
    }

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

    if (strpos($instruction, 'jnz') === 0) { // jump if not zero
        $a = array_pop($stack);

        if ($a) {
            $label = explode(' ', $instruction)[1];
            $pointer = $labels[$label];
        } else {
            $pointer++;
        }

        continue;
    }

    $pointer++;

    // label
    if ($instruction && $instruction[0] === ':') {
        continue;
    }

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

//    display($stack, $instructions, $labels, $pointer);



}
