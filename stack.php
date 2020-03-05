<?php

$stack = [];

$instructions = "2 * 3 + 5";
$instructions = "2 3 * 5 +";

$instructions = explode(' ', $instructions);


while(true) {
    echo implode(', ', $stack);
    $instructions = readline("\n> ");

    $instructions = explode(' ', $instructions);

    while (count($instructions)) {
        $instruction = trim(array_shift($instructions));

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
    }

}
