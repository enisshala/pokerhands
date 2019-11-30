<?php

namespace enisshala\pokerhands;

use enisshala\pokerhands\HandTypes;

class PreciseStrength
{
    /** Format hand and return hand numbers as array
     * @param $hand
     * @return array
     */
    public function formatHand($hand)
    {
        if (isset($hand['hand'])){
            $hand_array = explode(" ", $hand['hand']);
        } else {
            $hand_array = explode(" ", $hand);
        }
        $format_hand_number = array();
        foreach ($hand_array as $hand) {
            $format = str_replace("\"", "", json_encode($hand));
            $formatted = str_replace("\\r", "", $format);
            $format_hand_number[] = explode("\\", $formatted, 2)[0];
        }

        return $format_hand_number;
    }


    /** Format hand and return hand suits as array
     * @param $hand
     * @return array
     */
    public function formatHandSuit($hand)
    {
        if (isset($hand['hand'])){
            $hand_array = explode(" ", $hand['hand']);
        } else {
            $hand_array = explode(" ", $hand);
        }
        $format_hand_suit = array();
        foreach ($hand_array as $hand) {
            $format = str_replace("\"", "", json_encode($hand));
            $formatted = str_replace("\\r", "", $format);
            $format_hand_suit[] = explode("\\", $formatted, 2)[1];
        }

        return $format_hand_suit;
    }


    /** precise ranking for four of a kind
     * @param $hand
     * @return int
     */
    public function isHighestFour($hand)
    {
        $firstHand = $this->formatHand($hand);

        $tmp1 = array_count_values($firstHand);
        foreach ($tmp1 as $key => $value) {
            if ($value == 4) {
                if ($key == "A") {
                    $highest = 14;
                } elseif ($key == "K") {
                    $highest = 13;
                } elseif ($key == "Q") {
                    $highest = 12;
                } elseif ($key == "J") {
                    $highest = 11;
                } else {
                    $highest = (int)$key;
                }
            }
        }
        return $highest;

    }


    /** precise ranking for full house in the same rank
     * @param $hand
     * @return int
     */
    public function isHighestFullHouse($hand)
    {
        $firstHand = $this->formatHand($hand);

        $tmp1 = array_count_values($firstHand);
        foreach ($tmp1 as $key => $value) {
            if ($value == 3) {
                if ($key == "A") {
                    $highest = 14;
                } elseif ($key == "K") {
                    $highest = 13;
                } elseif ($key == "Q") {
                    $highest = 12;
                } elseif ($key == "J") {
                    $highest = 11;
                } else {
                    $highest = (int)$key;
                }
            }
        }

        return $highest;
    }


    /** precise ranking of the three of a kind
     * @param $hand
     * @return int
     */
    public function isHighestThree($hand)
    {
        $firstHand = $this->formatHand($hand);

        $tmp1 = array_count_values($firstHand);
        foreach ($tmp1 as $key => $value) {
            if ($value == 3) {
                if ($key == "A") {
                    $highest = 14;
                } elseif ($key == "K") {
                    $highest = 13;
                } elseif ($key == "Q") {
                    $highest = 12;
                } elseif ($key == "J") {
                    $highest = 11;
                } else {
                    $highest = (int)$key;
                }
            }
        }

        return $highest;
    }


    /** precise rank for straight
     * @param $hand
     * @return int
     */
    public function isHighestStraight($hand)
    {
        $firstHand = $this->formatHand($hand);

        $format_hand_number_straight = array();
        foreach ($firstHand as $number) {
            if ($number == 'J') {
                $format_hand_number_straight[] = '11';
            } elseif ($number == 'Q') {
                $format_hand_number_straight[] = '12';
            } elseif ($number == 'K') {
                $format_hand_number_straight[] = '13';
            } elseif ($number == 'A') {
                $format_hand_number_straight[] = '14';
            } else {
                $format_hand_number_straight[] = $number;
            }
        }

        sort($format_hand_number_straight);

        $lowestStraight = array('14', '2', '3', '4', '5');
        $count_equals = count(array_intersect($lowestStraight, $format_hand_number_straight));

        if ($count_equals == 5) {
            $highest = 5;
        } else {
            $highest = max($format_hand_number_straight);
        }

        return (int)$highest;
    }


    /** precise ranking for the flush hands of the same level
     * @param $hand
     * @return float|int
     */
    public function isHighestFlush($hand)
    {
        $firstHand = $this->formatHand($hand);

        $format_hand_number_straight = array();
        foreach ($firstHand as $number) {
            if ($number == 'J') {
                $format_hand_number_straight[] = 11;
            } elseif ($number == 'Q') {
                $format_hand_number_straight[] = 12;
            } elseif ($number == 'K') {
                $format_hand_number_straight[] = 13;
            } elseif ($number == 'A') {
                $format_hand_number_straight[] = 14;
            } else {
                $format_hand_number_straight[] = (int)$number;
            }
        }

        return array_sum($format_hand_number_straight);
    }


    /** precise rank for the two pair of the same level
     * @param $hand
     * @return int
     */
    public function isHighestTwo($hand)
    {
        $firstHand = $this->formatHand($hand);

        $format_hand_number_straight = array();
        foreach ($firstHand as $key => $value) {
            if ($value == 'J') {
                $format_hand_number_straight[] = 11;
            } elseif ($value == 'Q') {
                $format_hand_number_straight[] = 12;
            } elseif ($value == 'K') {
                $format_hand_number_straight[] = 13;
            } elseif ($value == 'A') {
                $format_hand_number_straight[] = 14;
            } else {
                $format_hand_number_straight[] = (int)$value;
            }
        }

        rsort($format_hand_number_straight);
        $values_arr = array_count_values($format_hand_number_straight);
        $arr = array();
        foreach ($values_arr as $key => $value) {
            if ($value == 2) {
                $arr[] = $key;
            }
        }
//        foreach ($values_arr as $key => $value) {
//            if ($value == 1){
//                $arr[] = $key;
//            }
//        }

        return (int)implode("", $arr);
    }


    /** precise rank strength for the pair hands
     * @param $hand
     * @return int
     */
    public function isHighestPair($hand)
    {
        $firstHand = $this->formatHand($hand);

        $format_hand_number_straight = array();
        foreach ($firstHand as $key => $value) {
            if ($value == 'J') {
                $format_hand_number_straight[] = 11;
            } elseif ($value == 'Q') {
                $format_hand_number_straight[] = 12;
            } elseif ($value == 'K') {
                $format_hand_number_straight[] = 13;
            } elseif ($value == 'A') {
                $format_hand_number_straight[] = 14;
            } else {
                $format_hand_number_straight[] = (int)$value;
            }
        }

        rsort($format_hand_number_straight);
        $values_arr = array_count_values($format_hand_number_straight);
        $arr = array();
        foreach ($values_arr as $key => $value) {
            if ($value == 2) {
                $arr[] = $key;
            }
        }
//        foreach ($values_arr as $key => $value) {
//            if ($value == 1){
//                $arr[] = $key;
//            }
//        }

        return (int)implode("", $arr);
    }


    /** precise rank for hands on highest card level
     * @param $hand
     * @return float|int
     */
    public function isHighestCard($hand)
    {
        $firstHand = $this->formatHand($hand);

        $format_hand_number_straight = array();
        foreach ($firstHand as $number) {
            if ($number == 'J') {
                $format_hand_number_straight[] = 11;
            } elseif ($number == 'Q') {
                $format_hand_number_straight[] = 12;
            } elseif ($number == 'K') {
                $format_hand_number_straight[] = 13;
            } elseif ($number == 'A') {
                $format_hand_number_straight[] = 14;
            } else {
                $format_hand_number_straight[] = (int)$number;
            }
        }

        rsort($format_hand_number_straight);
        return (int)implode($format_hand_number_straight);
    }
}