<?php

function permutations(array $elements) {
    if (!function_exists('getPossibleCharCombinations')) {
        function getPossibleCharCombinations($size, $combinations = array()) {
            $chars = array('>', '<');
            if (empty($combinations)) {
                $combinations = $chars;
            }
            if ($size == 1) {
                return $combinations;
            }
            $new_combinations = array();
            foreach ($combinations as $combination) {
                foreach ($chars as $char) {
                    $new_combinations[] = $combination . $char;
                }
            }
            return getPossibleCharCombinations($size - 1, $new_combinations);
        }
    }

    if (!function_exists('getPossibleUniqCharCombinations')) {
        function getPossibleUniqCharCombinations($arr, $temp_string, &$collect, $startLength = null) {
            $startLength = $startLength ?? count($arr);

            if ($temp_string != "") {
                $tempRes = explode(' ', trim($temp_string));
                if (count($tempRes) === $startLength) {
                    $collect [] = $tempRes;
                }
            }

            for ($i=0, $iMax = sizeof($arr); $i < $iMax; $i++) {
                $arrcopy = $arr;
                $elem = array_splice($arrcopy, $i, 1);
                if (sizeof($arrcopy) > 0) {
                    getPossibleUniqCharCombinations($arrcopy, $temp_string ." " . $elem[0], $collect, $startLength);
                } else {
                    $res = explode(' ', trim($temp_string. " " . $elem[0]));
                    if (count($res) === $startLength) {
                        $collect [] = $res;
                    }
                }
            }
        }
    }



    $listLength = count($elements);
    $charsCombinations = getPossibleCharCombinations($listLength - 1);
    $charsUniqCombinations = array();
    getPossibleUniqCharCombinations($elements, "", $charsUniqCombinations);

    $result = array();

    foreach ($charsUniqCombinations as $combination) {
        foreach ($charsCombinations as $charsCombination) {
            $resCombination = array();
            for ($i = 0; $i < $listLength - 1; $i++) {
                $resCombination[] = $combination[$i];
                $resCombination[] = $charsCombination[$i];
                if ($i + 1 === $listLength -1) {
                    $resCombination[] = $combination[$i + 1];
                }
            }
            $result[] = $resCombination;
        }
    }

    return $result;
}

$list = array('A', 'B', 'C');

foreach (permutations($list) as $permutation) {
//    echo implode(' ', $permutation) . '</br>';
    echo implode(' ', $permutation) . PHP_EOL;
}
