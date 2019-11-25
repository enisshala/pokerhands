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
        $hand_array = explode(" ", $hand);
//        var_dump($hand_array);
        $format_hand_number = array();
        $format_hand_suit = array();
        foreach ($hand_array as $hand) {
            $format = str_replace("\"", "", json_encode($hand));
            $formatted = str_replace("\\r", "", $format);
            $format_hand_number[] = explode("\\", $formatted, 2)[0];
            $format_hand_suit[] = explode("\\", $formatted, 2)[1];
        }

//        var_dump($format_hand_suit);
//        die();

        $handType = new HandTypes();
        $isRoyalFlush = $handType->isRoyalFlush($format_hand_number, $format_hand_suit);
        $isStraightFlush = $handType->isStraightFlush($format_hand_number, $format_hand_suit);
        $isFourPair = $handType->isFourPair($format_hand_number);
        $isFullHouse = $handType->isFullHouse($format_hand_number);
        $isFlush = $handType->isFlush($format_hand_suit);

        if ($isRoyalFlush) {

        } elseif ($isStraightFlush) {

        } else if ($isFourPair) {

        } else if ($isFullHouse) {

        } else if ($isFlush) {

        }

        return $isFlush;

    }
}
