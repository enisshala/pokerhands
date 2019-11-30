<?php

require_once __DIR__ . '/vendor/autoload.php';

use enisshala\pokerhands\PokerClass;

class IndexTest
{

    public function test($file_path)
    {

        $hands = new PokerClass();
        $sorted_hands = $hands->sortHands($file_path);

        foreach ($sorted_hands as $hand){
            var_dump($hand);
        }
    }
}