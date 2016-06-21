<?php

class Admin extends CActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{admins}}';
    }
    
  
    function generatePassword($number = 10, $lit = array(0,1,2)) { 
        # массивы символов
        $array_pass_0 = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'v', 'x', 'y', 'z');
        $array_pass_1 = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'V', 'X', 'Y', 'Z');
        $array_pass_2 = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0');
        $passwd = "";
        for ($rnd = 0; $rnd < $number; $rnd++) {         
            $array_pass = ${'array_pass_'.$lit[mt_rand(0, count($lit)-1)]}; # выбираем случайный массив символов       
            $random_pass = mt_rand(0, count($array_pass) - 1);  # выбираем случайный символ из массива символов        
            $passwd .= $array_pass[$random_pass]; # приписываем к строке пароля один символ    
        }       
        return $passwd; 
    } 
    
}
