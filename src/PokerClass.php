<?php

namespace enisshala\pokerhands;

use enisshala\pokerhands\HandTypes;
use enisshala\pokerhands\PreciseStrength;

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
            $hand_strength = $poker->checkStrength($hand);
            array_push($ranked_array,
                array(
                    'id' => $i,
                    'hand' => $hand,
                    'hand_strength' => (float)$hand_strength
                )
            );
            $i++;
        }


        // check if there are hands on same level of strength
        $strengths = array();
        foreach ($ranked_array as $item) {
            $strengths[] = intval($item['hand_strength']);
        }

        $count_hands = array_count_values($strengths);

        $same_level_hands = array();
        foreach ($count_hands as $key => $value) {
            if ($value > 1) {
                $same_level_hands[] = $key;
            }
        }

        // if there are hands in the same level of strength, make precision ranking and update array
        if (count($same_level_hands) > 0) {
            foreach ($ranked_array as $item => $value) {
                if (in_array($value['hand_strength'], $same_level_hands)) {
                    $hand = new PreciseStrength();
                    switch ($value['hand_strength']) {
                        case 2:
                            $precise_rank = $hand->isHighestStraight($value);
                            $ranked_array[$item]['hand_strength'] = 2 - ($precise_rank / 100);
                            break;
                        case 3:
                            $precise_rank = $hand->isHighestFour($value);
                            $ranked_array[$item]['hand_strength'] = 3 - ($precise_rank / 100);
                            break;
                        case 4:
                            $precise_rank = $hand->isHighestFullHouse($value);
                            $ranked_array[$item]['hand_strength'] = 4 - ($precise_rank / 100);
                            break;
                        case 5:
                            $precise_rank = $hand->isHighestFlush($value);
                            $ranked_array[$item]['hand_strength'] = 5 - ($precise_rank / 100);
                            break;
                        case 6:
                            $precise_rank = $hand->isHighestStraight($value);
                            $ranked_array[$item]['hand_strength'] = 6 - ($precise_rank / 1000);
                            break;
                        case 7:
                            $precise_rank = $hand->isHighestThree($value);
                            $ranked_array[$item]['hand_strength'] = 7 - ($precise_rank / 1000);
                            break;
                        case 8:
                            $precise_rank = $hand->isHighestTwo($value);
                            $ranked_array[$item]['hand_strength'] = 8 - ($precise_rank / 1000);
                            break;
                        case 9:
                            $precise_rank = $hand->isHighestPair($value);
                            $ranked_array[$item]['hand_strength'] = 9 - ($precise_rank / 1000);
                            break;
                        case 10:
                            $precise_rank = $hand->isHighestCard($value);
                            $ranked_array[$item]['hand_strength'] = 10 - ($precise_rank / 1000);
                            break;

                        default:
                            continue;
                    }
                }
            }
        }

        //sort based on strength parameter in array
        usort($ranked_array, function ($a, $b) {
            return $a['hand_strength'] > $b['hand_strength'] ? 1 : -1;
        });

        //sort only hands
        $final_array = array();
        foreach ($ranked_array as $arr) {
            $final_array[] = $arr['hand'];
        }

        return $final_array;
    }


    public function getDataURL($file_path)
    {
        $file_hands = file_get_contents($file_path);
        $hands_array = explode("\n", $file_hands);

        return $hands_array;
    }


    public function checkStrength($hand)
    {
        $format_hand = new PreciseStrength();
        $format_hand_number = $format_hand->formatHand($hand);
        $format_hand_suit = $format_hand->formatHandSuit($hand);

        $handType = new HandTypes();
        $isStraight = $handType->isStraight($format_hand_number);
        $isFlush = $handType->isFlush($format_hand_suit);
        $isPair = $handType->isPair($format_hand_number, $format_hand_suit);
        $isTwoPair = $handType->isTwoPair($format_hand_number, $format_hand_suit);
        $isThreePair = $handType->isThreePair($format_hand_number, $format_hand_suit);
        $isFullHouse = $handType->isFullHouse($format_hand_number, $format_hand_suit);
        $isFourPair = $handType->isFourPair($format_hand_number, $format_hand_suit);
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
            return 10;
        }
    }

}