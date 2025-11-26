<?php
    function get_key() {
       $seed = rand(0,getrandmax());
       $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890!@#$%^&*()-=~"';
       $max = strlen($chars);
       for ($i=0;$i<32;$i++) {
           $seed .= $chars[rand(0,$max)];
       }
       $seed = substr($seed,0,32);
       return $seed;
    }
    function asciiChars() {
       return "$*^(";
    }
?>
