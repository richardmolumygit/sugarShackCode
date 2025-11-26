<?php
  require "common_functions.php";

  $log_file = "addToCart.log";
  $fp = fopen($log_file,'w');

  $sessionId = session_id();
  fwrite ($fp,logTime()."-sessionId-".$sessionId."-\n");

  fwrite($fp,logTime()."begin-POST-values\n");
  foreach ($_POST as $id=>$value) {
     fwrite($fp,logTime()."id<".$id.">value<".$value.">\n");
  }
  foreach ($_GET as $id=>$value) {
     fwrite($fp,logTime()."id<".$id.">value<".$value.">\n");
  }
  unset($qtyInput);
  unset($postId);
  unset($itemNbr);
  unset($radioChoice);
  if (isset($_POST['qtyInput'])) {
     $qtyInput = $_POST['qtyInput'];
  } else if (isset($_GET['qtyInput'])) {
     $qtyInput = $_GET['qtyInput'];
  }
  if (isset($_POST['postId'])) {
     $postId = $_POST['postId'];
  } else if (isset($_GET['postId'])) {
     $postId = $_GET['postId'];
  }
  if (isset($_POST['itemNbr'])) {
     $itemNbr = $_POST['itemNbr'];
  } else if (isset($_GET['itemNbr'])) {
     $itemNbr = $_GET['itemNbr'];
  }
  if (isset($_POST['radioChoice'])) {
     $radioChoice = $_POST['radioChoice'];
  } else if (isset($_GET['radioChoice'])) {
     $radioChoice = $_GET['radioChoice'];
  }
  $conn = db_connect();
  $qty='';
  if ($conn) {
     $log_file = "addToCart.log";
     $fp = fopen($log_file,'w');
     fwrite($fp,logTime()."-start-\n");
     if (empty($radioChoice)) {
        if (isset($qtyInput)) {
           $qty = $qtyInput;
        }
     } else {
        if (isset($radioChoice)) {
           $qty = $radioChoice;
        }
     }
     if (! empty($qty) ) {
        $insertStmt = "INSERT INTO shoppingCart (tableId, cartId, itemNbr, quantity) VALUES (NULL,'".$sessionId."','".$itemNbr."','".$qty."')";
        fwrite($fp,"--insertStmt-".$insertStmt."-\n");
        if ($conn->query($insertStmt) === TRUE ) {
           fwrite($fp,"-Success-\n");
        } else {
           fwrite($fp,"-Failure-\n");
        }
     }
     fclose($fp);
  } // if $(conn)
  header('Location: mainPage.php');
?>
