<?php

// get the input parenthesesmeter from URL

$input = $_REQUEST["input"];
$input = str_replace(" ", "+", $input);  // replace the space with +. not sure why this is occuring.
// $input = ".5x(5+3)";
$input = str_split($input);  // create array
$arr = [];
$parenthesesArr = [];
$parenthesesSum = "";
$number = "";
$parenthesesCount = 0;

//format the input
for ($i = 0; $i < count($input); $i++) {
    if (is_numeric($input[$i]) || $input[$i] == ".") {
        $number .= $input[$i]; // add the . to the number 
    } else if (!is_numeric($input[$i])) { // not number
        if ($input[$i] == "(") {
            $firstparentheses = $i;
            for ($g = $i; $g < count($input); $g++) {  // get the parentheses in the string and send to calculate
                $parenthesesArr[] = $input[$g];
                if ($input[$g] == ")") {
                    for ($h = 0; $h < count($parenthesesArr); $h++) {  //check and remove the ()
                        if ($parenthesesArr[$h] == "(" || $parenthesesArr[$h] == ")") {
                            unset($parenthesesArr[$h]);
                            $parenthesesArr = array_values($parenthesesArr); // reindex array
                            $parenthesesCount++;
                        }
                    }

                    $parenthesesSum = calculateString($parenthesesArr);  // returns the sum              
                    array_splice($input, $firstparentheses, (count($parenthesesArr) + $parenthesesCount), $parenthesesSum);  //splice the result into the array. first array, start, length, other array
                    $parenthesesCount = 0;
                    $parenthesesArr = [];
                }
            }
        }
        if (!empty($number)) {
            // if number is not empty add it to the array
            $arr[] = $number;
            $number = ""; //reset number
        }
        $arr[] = $input[$i];
    }
}
if (!empty($number)) {
    $arr[] = $number;
}

// print_r($arr);
//send to the cacluate function 
echo calculateString($arr);

// calculate
function calculateString($arr){
    $value = 0;
    $operator = null;
    // echo count($arr);
    for ($i = 0; $i < count($arr); $i++) {
        if (is_numeric($arr[$i]) && $operator) { // skips the operator and checks for the next number
            if ($operator == "x") {
                $value = $value * $arr[$i];
            }
            if ($operator == "/") {
                $value = $value / $arr[$i];
            }
            if ($operator == "+") {
                $value = $value + $arr[$i];
            }
            if ($operator == "-") {
                $value = $value - $arr[$i];
            }
            $operator = null;
        } elseif ($value == 0) {
            $value = $arr[$i];
        } elseif ($arr[$i] == "%") {
            $value = $value * .01;
        } else {  // get operator
            $operator = $arr[$i];
        }
    }
    if (strpos($value, ".") !== false) {
        // echo number_format($value, 3);
        $value = number_format($value, 3);
        return $value;
    } else return $value;
}
?>