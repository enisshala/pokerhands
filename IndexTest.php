<?php

require_once __DIR__ . '/vendor/autoload.php';

use enisshala\pokerhands\PokerClass;

class IndexTest
{

    public function test($file_path)
    {

        $hands = new PokerClass();
        $sorted_hands = $hands->sortHands($file_path);


        var_dump($sorted_hands);

    }

}