<?php
  session_start();
  //session_register();
/*
  $curHost = $_SERVER['HTTP_HOST'];
  $curPage = $_SERVER['PHP_SELF'];
  $docRoot = $_SERVER['DOCUMENT_ROOT'];
  $queryString = $_SERVER['QUERY_STRING'];
*/
  include_once("logFiles.php");
  include_once("db_conn.php");
  include_once("seedRandomizer.php");
  unset($isAdmin);
  if (isset($_SESSION['isAdmin'])) {
     $isAdmin = true;
     fwrite($fp,logTime()."-common_functions-isAdmin-true-\n");
  }

  function isActiveSession() {
    global $fp;
    if (isset($_SESSION['isActive'])) {
       $isActive = $_SESSION['isActive'];
       fwrite($fp,logTime()."-commmon_functions-isActive[SESSION]".$isActive."-\n");
    }
    if (isset($_POST['isActive'])) {
       $isActive = $_POST['isActive'];
       fwrite($fp,logTime()."-commmon_functions-isActive[POST]".$isActive."-\n");
    }
    if (isset($_GET['isActive'])) {
       $isActive = $_GET['isActive'];
       fwrite($fp,logTime()."-commmon_functions-isActive[GET]".$isActive."-\n");
    }
    if (isset($isActive)) {
       return (true);
    }
    return (false);
  }

  function passgen() {
     $vowels = "aeiou";
     $consonants = "bcdfghjklmnpcqrstvwxyz";
     $digits = "0123456789";

     for ($i = 0; $i < 2; $i++) {
         $key .= $consonants[rand(0,21)];
         $key .= $vowels[rand(0,4)];
         $key .= $consonants[rand(0,21)];
         $key .= $digits[rand(0,9)];
     }
     return ($key);
  }
?>
