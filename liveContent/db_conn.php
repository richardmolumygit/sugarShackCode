<?php
  function db_connect() {
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
   
    $host = "sql104.infinityfree.com";
    $database_name = 'if0_40216765_secret_php_db'; // Set this to your Database Name
    $database_username = 'if0_40216765'; // Set this to your MySQL username
    $database_password = 'b6ZQF3iDIM'; // Set this to your MySQL password
  
    $host = "localhost";
    $database_name = 'rmolumby_alertone'; // Set this to your Database Name
    $database_username = 'rmolumby_uname'; // Set this to your MySQL username
    $database_password = 'R1ch@rD'; // Set this to your MySQL password
  

    $result = mysqli_connect($host, $database_username, $database_password, $database_name);

    if (!$result) return false;
    return $result;
  }
?>
