<?php

  $server = "sql104.infinityfree.com";
  $username = "if0_40216765";
  $password = "b6ZQF3iDIM";
  $dbname = "if0_40216765_secret_php_db";
  
  $conn = mysqli_connect($server, $username, $password, $dbname);
  
  if(! $conn) {
    die("Connection Failed: ".mysqil_connect_error());
  }