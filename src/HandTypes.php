<?php

namespace enisshala\pokerhands;

class HandTypes
{

    /**
     * Create a new HandTypes Instance
     */
    public function __construct()
    {


    }


    public function isRoyalFlush($format_hand_number, $format_hand_suit)
    {
        $royal = array('10', 'J', 'Q', 'K', 'A');
        $count_equals = count(array_intersect($royal, $format_hand_number));
        $isFlush = $this->isFlush($format_hand_suit);

        if ($count_equals == 5 && $isFlush == true) {
            return true;
        }
        return false;
    }


    public function isStraightFlush($format_hand_number, $format_hand_suit)
    {
        $format_hand_number_new = array();
        foreach ($format_hand_number as $number) {
            if ($number == 'J') {
                $format_hand_number_new[] = '11';
            } elseif ($number == 'Q') {
                $format_hand_number_new[] = '12';
            } elseif ($number == 'K') {
                $format_hand_number_new[] = '13';
            } elseif ($number == 'A') {
                $format_hand_number_new[] = '14';
            } else {
                $format_hand_number_new[] = $number;
            }
        }

        sort($format_hand_number_new);
        $isStraight = $this->isStraight($format_hand_number_new);
        $isFlush = $this->isFlush($format_hand_suit);

        if ($isStraight == true && $isFlush == true) {
            return true;
        }

        return false;

    }


    public function isFourPair($hand_numbers)
    {
        $tmp = array_count_values($hand_numbers);
        $isFourPair = false;
        foreach ($tmp as $t) {
            if ($t == 4) {
                $isFourPair = true;
            }
        }

        return $isFourPair;
    }


    public function isFullHouse($hand_numbers)
    {

        $hand_numbers_count = count(array_unique($hand_numbers));

        $isFullHouse = false;
        if ($hand_numbers_count == 2) {
            $tmp = array_count_values($hand_numbers);
            foreach ($tmp as $t) {
                if ($t == 3) {
                    $isFullHouse = true;
                }
            }
        }

        return $isFullHouse;
    }


    public function isFlush($format_hand_suit)
    {
        $counts_suits = count(array_unique($format_hand_suit));

        $isFlush = false;
        if ($counts_suits == 1) {
            $isFlush = true;
        }

        return $isFlush;
    }


    public function isStraight($format_hand_number_new)
    {
        $isStraight = false;
        for ($i = 0; $i < 4; $i++) {
            if ($format_hand_number_new[$i] == $format_hand_number_new[$i + 1] - 1) {
                $isStraight = true;
            } else {
                $isStraight = false;
                break;
            }
        }

        return $isStraight;
    }

    public function isThreePair($hand_numbers)
    {
        $tmp = array_count_values($hand_numbers);

        $isThreePair = false;
        if (count($tmp) == 3) {
            foreach ($tmp as $t) {
                if ($t == 3) {
                    $isThreePair = true;
                }
            }
        }

        return $isThreePair;
    }


    public function isTwoPair($hand_numbers)
    {
        $tmp = array_count_values($hand_numbers);

        $isTwoPair = false;
        if (count($tmp) <= 3) {
            foreach ($tmp as $t) {
                if ($t <= 2) {
                    $isTwoPair = true;
                }
            }
        }

        return $isTwoPair;
    }


    public function isPair($hand_numbers)
    {
        $tmp = array_count_values($hand_numbers);

        $isPair = false;
        if (count($tmp) < 5) {
            foreach ($tmp as $t) {
                if ($t == 2) {
                    $isPair = true;
                }
            }
        }

        return $isPair;
    }


    public function isHighCard($hand_numbers)
    {
        $formatted_hands = array();
        foreach ($hand_numbers as $hand) {
            if ($hand == "A") {
                $formatted_hands[] = '14';
            } elseif ($hand == "K") {
                $formatted_hands[] = '13';
            } elseif ($hand == "Q") {
                $formatted_hands[] = '12';
            } elseif ($hand == "J") {
                $formatted_hands[] = '11';
            } else {
                $formatted_hands[] = $hand;
            }
        }
        rsort($formatted_hands);

        return $formatted_hands[0];

    }

}
