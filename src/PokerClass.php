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
        $ranked_array = array();
        $i = 0;
        foreach ($hands_array as $hand) {
            $poker = new PokerClass();
            $hand_strength = json_decode($poker->checkStrength($hand));
            var_dump($hand_strength);
            die();
            array_push($ranked_array,
                array(
                    'id' => $i,
                    'hand' => $hand,
                    'hand_strength' => $hand_strength
                )
            );
            $i++;
        }

        //sort based on strength parameter in array
        usort($ranked_array, function ($a, $b) {
            return $a['hand_strength'] <=> $b['hand_strength'];
        });


        $total = count($ranked_array);
        for ($i = 0; $i < $total - 1; $i++) {
            if ($ranked_array[$i]['hand_strength'] == $ranked_array[$i + 1]['hand_strength']) {
                $handType = new HandTypes();

                if ($ranked_array[$i]['hand_strength'] = 3) {
                    $isHigher = $handType->isHighestFour($ranked_array[$i], $ranked_array[$i + 1]);
                    var_dump($isHigher);
                    die();
                } elseif ($ranked_array[$i]['hand_strength'] = 4) {
                    return "ok";
                } else {
                    return "okok";
                }

//                var_dump($ranked_array[$i]);
//                var_dump($ranked_array[$i + 1]);
//                die();
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
        $isTwoPair = json_decode($handType->isTwoPair($format_hand_number));
        $isThreePair = json_decode($handType->isThreePair($format_hand_number));
        $isFullHouse = json_decode($handType->isFullHouse($format_hand_number));
        $isFourPair = json_decode($handType->isFourPair($format_hand_number));


        var_dump($isTwoPair);
        die();

        if ($isFourPair->status == true) {
            $isFourPairStrength = array(
                'strength' => 3,
                'high_card' => $isFourPair->high_card
            );
            return json_encode($isFourPairStrength);

        } elseif ($isThreePair->status == true) {
            $isThreePairStrength = array(
                'strength' => 7,
                'high_card' => $isThreePair->high_card
            );
            return json_encode($isThreePairStrength);

        } elseif ($isFullHouse->status == true) {
            $isFullHouseStrength = array(
                'strength' => 4,
                'high_card' => $isFullHouse->high_card
            );
            return json_encode($isFullHouseStrength);

        } elseif ($isTwoPair->status == true) {
            $isTwoPairStrength = array(
                'strength' => 8,
                'high_card' => $isTwoPair->high_card
            );
            return json_encode($isTwoPairStrength);
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
