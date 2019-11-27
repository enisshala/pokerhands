<?php

namespace enisshala\pokerhands;

use enisshala\pokerhands\HandTypes;

class PokerClass
{

    /**
     * Create a new PokerClass Instance
     */
    public function __construct()
    {
    }

    public function sortHands($hand_file)
    {
        $hands_array = $this->getDataURL($hand_file);
        //some shit to do around here - tired af - going to sleep
        $ranked_array = array();
        foreach ($hands_array as $hand) {
            $poker = new PokerClass();
            $hand_strength = $poker->checkStrength($hand);
//            var_dump($hand_strength);
//            array_push($ranked_array,
//                    $hand,
//                    $hand_strength
//
//            );

            $ranked_array[$hand] = $hand_strength;
        }
//        die();

//        var_dump($ranked_array);

        asort($ranked_array);
//        var_dump($ranked_array);
        $repeated = array_count_values($ranked_array);
//        var_dump($repeated);

        foreach ($repeated as $item => $id) {
            if ($id > 1){
                var_dump($item);
                foreach ($ranked_array as $arr => $idnew) {
                    if ($idnew == $item) {
                        var_dump($arr);

                    }
                }
            }
        }

    }


    public function getDataURL($file_path)
    {
        $file_hands = file_get_contents($file_path);
        $hands_array = explode("\n", $file_hands);

        return $hands_array;
    }


    public function checkStrength($hand)
    {
        $hand_array = explode(" ", $hand);
        $format_hand_number = array();
        $format_hand_suit = array();
        foreach ($hand_array as $hand) {
            $format = str_replace("\"", "", json_encode($hand));
            $formatted = str_replace("\\r", "", $format);
            $format_hand_number[] = explode("\\", $formatted, 2)[0];
            $format_hand_suit[] = explode("\\", $formatted, 2)[1];
        }

        $handType = new HandTypes();
        $isStraight = $handType->isStraight($format_hand_number);
        $isFlush = $handType->isFlush($format_hand_suit);
        $isPair = $handType->isPair($format_hand_number);
        $isTwoPair = $handType->isTwoPair($format_hand_number);
        $isThreePair = $handType->isThreePair($format_hand_number);
        $isFullHouse = $handType->isFullHouse($format_hand_number);
        $isFourPair = $handType->isFourPair($format_hand_number);

        if ($isFourPair == true) {
            return 3;
        } elseif ($isThreePair == true) {
            return 7;
        } elseif ($isFullHouse == true) {
            return 4;
        } elseif ($isTwoPair == true) {
            return 8;
        } elseif ($isPair == true) {
            return 9;

        } elseif ($isStraight == true) {
            $isStraightFlush = $handType->isStraightFlush($format_hand_number, $format_hand_suit);
            if ($isStraightFlush == true) {
                $isRoyalFlush = $handType->isRoyalFlush($format_hand_number, $format_hand_suit);
                if ($isRoyalFlush == true) {
                    return 1;
                } else {
                    return 2;
                }

            } else {
                return 6;
            }

        } elseif ($isFlush == true) {
            return 5;
        } else {
//            $isHighCard = $handType->isHighCard($format_hand_number);
            return 10;
        }

    }
}
