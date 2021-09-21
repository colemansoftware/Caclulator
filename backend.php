<?php

    // get the input parameter from URL
    
    $input = $_REQUEST["input"];
    $input = str_replace(" ", "+", $input);  // replace the space with +. not sure why this is occuring.
    $input = str_split($input);
    $arr = [];
    $number = "";
    foreach ($input as $num){
        // echo $num;
        if(is_numeric($num) || $num == "."){ // if number or decimal
            $number .= $num;
        }else if(!is_numeric($num)){ // not number
            if(!empty($number)){  // if number is not empty add it to the array
                $arr[] = $number;
                $number = ""; //reset number
            }
            $arr[] = $num; 
        }
    }
    // echo $number;
    if(!empty($number)){
        $arr[] = $number;
    }

    // calculate
    $value = 0;
    $operator = null;
    // echo count($arr);
    for($i=0; $i<= count($arr)-1; $i++){
        if(is_numeric($arr[$i]) && $operator){// skips the operator and checks for the next number
            if($operator == "x"){
                $value = $value * $arr[$i];
            }
            if($operator == "/"){
                $value = $value / $arr[$i];
            }
            if($operator == "+"){
                $value = $value + $arr[$i];
            }
            if($operator == "-"){
                $value = $value - $arr[$i];
            }
            $operator = null;
        }elseif ($value == 0){
            $value = $arr[$i];
        }elseif($arr[$i] == "%"){
            $value = $value * .01;
        }else{  // get operator
            $operator = $arr[$i];
        }
    }

    if (strpos($value, ".") !== false) {
        echo number_format($value, 3);
    }else echo $value;
    
?>