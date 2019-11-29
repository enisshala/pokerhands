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
        $isStraight = $this->isStraight($format_hand_number);
        $isFlush = $this->isFlush($format_hand_suit);

        if ($isStraight == true && $isFlush == true) {
            return true;
        }

        return false;

    }


    public function isFourPair($hand_numbers, $format_hand_suit)
    {
        $isFlush = $this->isFlush($format_hand_suit);
        if ($isFlush == true) {
            $isFourPair = false;
        } else {
            $tmp = array_count_values($hand_numbers);
            $isFourPair = false;
            foreach ($tmp as $t) {
                if ($t == 4) {
                    $isFourPair = true;
                }
            }
        }

        return $isFourPair;
    }


    public function isFullHouse($hand_numbers, $format_hand_suit)
    {
        $isFlush = $this->isFlush($format_hand_suit);
        if ($isFlush == true) {
            $isFullHouse = false;
        } else {
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


    public function isStraight($format_hand_number)
    {
        $format_hand_number_straight = array();
        foreach ($format_hand_number as $number) {
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
            $isStraight = true;
        } else {
            $isStraight = false;
            for ($i = 0; $i < 4; $i++) {
                if ($format_hand_number_straight[$i] == $format_hand_number_straight[$i + 1] - 1) {
                    $isStraight = true;
                } else {
                    $isStraight = false;
                    break;
                }
            }
        }

        return $isStraight;
    }


    public function isThreePair($hand_numbers, $format_hand_suit)
    {
        $isFlush = $this->isFlush($format_hand_suit);
        if ($isFlush == true) {
            $isThreePair = false;
        } else {
            $tmp = array_count_values($hand_numbers);

            $isThreePair = false;
            if ((count($tmp) == 3)) {
                foreach ($tmp as $t) {
                    if ($t == 3) {
                        $isThreePair = true;
                    }
                }
            }
        }

        return $isThreePair;
    }


    public function isTwoPair($hand_numbers, $format_hand_suit)
    {
        $isFlush = $this->isFlush($format_hand_suit);
        if ($isFlush == true) {
            $isTwoPair = false;
        } else {
            $tmp = array_count_values($hand_numbers);

            $isTwoPair = false;
            if (count($tmp) <= 3) {
                foreach ($tmp as $t) {
                    if ($t <= 2) {
                        $isTwoPair = true;
                    }
                }
            }
        }

        return $isTwoPair;
    }


    public function isPair($hand_numbers, $format_hand_suit)
    {
        $isFlush = $this->isFlush($format_hand_suit);
        if ($isFlush == true) {
            $isPair = false;
        } else {
            $tmp = array_count_values($hand_numbers);

            $isPair = false;
            if (count($tmp) < 5) {
                foreach ($tmp as $t) {
                    if ($t == 2) {
                        $isPair = true;
                    }
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


    public function formatHand($hand)
    {
        $hand_array = explode(" ", $hand['hand']);
        $format_hand_number = array();
        $format_hand_suit = array();
        foreach ($hand_array as $hand) {
            $format = str_replace("\"", "", json_encode($hand));
            $formatted = str_replace("\\r", "", $format);
            $format_hand_number[] = explode("\\", $formatted, 2)[0];
            $format_hand_suit[] = explode("\\", $formatted, 2)[1];
        }

        return $format_hand_number;
    }

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

        return max($format_hand_number_straight);
    }

}