<?php

namespace enisshala\pokerhands;

class PokerClass
{

    /**
     * Create a new PokerClass Instance
     */
    public function __construct()
    {
    }


    public function checkStrength($hand)
    {
//        var_dump($hand);
        $hand_array = explode(" ", $hand);
        $format_hand = array();
        foreach ($hand_array as $hand) {
            $format = str_replace("\"","", json_encode($hand));
            $format_hand[] = str_replace("\r","", $format);

        }
        var_dump(str_replace("\\r","", $format_hand[4]));
        die();


        foreach ($hand as $card) {
//            var_dump($card);
        }
//        die();
//        $hand = json_encode($hand[0]);
//        var_dump($hand[4]);


        die();
    }
}
