<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of grade
 *
 * @author vialgouq
 */
class grade {
    function __construct() {
		
		

	}
    public function getGrade($capital, $zip){
            $dep=substr($zip,0,2);
           // $capital = intvar($capital);
            
            if($dep=="26"||$dep=="07"){
                if($capital>= 250000){
                    $grade="A";
                }
                else if($capital<250000 && $capital>=200000){
                    $grade="B";
                }
                else if($capital<200000 && $capital>=150000){
                    $grade="C";
                }
                else if($capital<150000 && $capital>=100000){
                    $grade="D";
                }
                else if($capital<100000){
                    $grade="E";
                }
            }
            else {
                if($capital>= 500000){
                    $grade="A";
                }
                else if($capital<500000 && $capital>=400000){
                    $grade="B";
                }
                else if($capital<400000 && $capital>=300000){
                    $grade="C";
                }
                else if($capital<300000 && $capital>=200000){
                    $grade="D";
                }
                else if($capital<200000){
                    $grade="E";
                }
            }
            
            
            return $grade;
        }
}
