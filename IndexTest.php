<?php

require_once __DIR__ . '/vendor/autoload.php';

use enisshala\pokerhands\PokerClass;

class IndexTest
{

    public function test($file_path)
    {

        $file_hands = file_get_contents($file_path);
        $hands_array = explode("\n", $file_hands);

        foreach ($hands_array as $hand) {
            $poker = new PokerClass();
            $hand_strength = $poker->checkStrength($hand);
        }

    }

    public function checkStrength($hand)
    {
//        var_dump();
        var_dump($hand);
        die();
    }
}