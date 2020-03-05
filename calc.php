<?php

$stack = [];

$instructions = "2 * 3 + 5";
$instructions = "2 3 * 5 +";

$instructions = explode(' ', $instructions);


while(true) {
    $instruction = readline("\n> ");

    // $instructions = explode(' ', $instructions);

    // echo implode(', ', $stack);

    while (count($instructions)) {
        $instruction = trim(array_shift($instructions));

        if (!is_numeric($instruction)) {
            $stack[] = $instruction;
            continue;
        }

        if (!$stack) {
            $stack[] = $instruction;
            continue;
        }

        $a = array_pop($stack);
        $b = array_pop($stack);
var_dump($a);
//var_dump($b);
        switch ($a) {
            case '+';
                $stack[] = $instruction + $b;
                break;
            case '*';
                $stack[] = $instruction * $b;
                break;
            case '-';
                $stack[] = $instruction - $b;
                break;
            case '/';
                $stack[] = $instruction / $b;
                break;
            case '**';
                $stack[] = pow($instruction, $b);
                break;
            case '%';
                $stack[] = $instruction % $b;
                break;
        }
    }

}
