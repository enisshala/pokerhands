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
        $counts_suits = count(array_unique($format_hand_suit));

        if ($count_equals == 5 && $counts_suits == 1) {
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

        $counts_suits = count(array_unique($format_hand_suit));

        if ($isStraight == true && $counts_suits == 1) {
            return true;
        }

        return false;

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

    public function isFourPair($hand_numbers) {
        //work to do here
        $hand_numbers_unique = array_unique($hand_numbers);
        var_dump($hand_numbers_unique);
        if (isset($hand_numbers_unique[4])){
            var_dump($hand_numbers_unique);

        }
        return "ok";
        die();
    }


    public function isFullHouse($hand_numbers) {

        $hand_numbers_count = count(array_unique($hand_numbers));

        $isFullHouse = false;
        if($hand_numbers_count == 2) {
            $isFullHouse = true;
        }

        return $isFullHouse;
    }

}
