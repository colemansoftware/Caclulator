<?php
// get the input parenthesesmeter from URL

$input = $_REQUEST["input"];
$input = str_replace(" ", "+", $input);  // replace the space with +. not sure why this is occuring.
// $input = "(1+1)+2x(2+3)";
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


$tempArray = [];
for ($i = 0; $i < count($arr); $i++){
    if ($arr[$i] == "("){
        for ($g = $i; $g < count($arr); $g++){
            if ($arr[$g] == ")"){
                array_push($tempArray, $arr[$g]);
                array_splice($arr, $i, count($tempArray), calculateString($tempArray));  //splice the result into the array. first array, start, length, return array
                //reset
                $tempArray = [];
                $i = 0;
                break;
            }else
                array_push($tempArray, $arr[$g]);
        }
    }
}

echo calculateString($arr);

// calculate
function calculateString($arr){
    //remove the p()) and calucate
    for ($i = 0; $i < count($arr); $i++) {
        if ($arr[$i] == "(" || $arr[$i] == ")") {
            unset($arr[$i]);
        }
    }
    $arr = array_values($arr); // reindex array
    $value = 0;
    $operator = null;
    for ($i = 0; $i < count($arr); $i++) {
        if (is_numeric($arr[$i]) && $operator) { // skip the operator and checks for the next number
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
        return number_format($value, 3);
    } else return $value;
}
?>