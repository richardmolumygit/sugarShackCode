<?php
  require "common_functions.php";

  $log_file = "deleteFromCart.log";
  $fp = fopen($log_file,'w');

  $sessionId = session_id();
  fwrite($fp,logTime()."sessionId-".$sessionId."-\n");
    
  fwrite($fp,logTime()."begin-POST-values\n");
  foreach ($_POST as $id=>$value) {
     fwrite($fp,logTime()."id<".$id.">value<".$value.">\n");
  }
  foreach ($_GET as $id=>$value) {
     fwrite($fp,logTime()."id<".$id.">value<".$value.">\n");
  }
  unset($tableId);
  if (isset($_POST['tableId'])) {
     $tableId = $_POST['tableId'];
  } else if (isset($_GET['tableId'])) {
     $tableId = $_GET['tableId'];
  }
  fwrite($fp,logTime()."tableId-".$tableId."-\n");
  $conn = db_connect();
  if ($conn) {
     fwrite($fp,logTime()."-start-\n");
     if (empty($radioChoice)) {
        if (isset($tableId)) {
           $qty = $tableId;
        }
     } else {
        if (isset($radioChoice)) {
           $qty = $radioChoice;
        }
     }
     if (! empty($qty) ) {
        $deleteStmt = "DELETE FROM shoppingCart WHERE tableId = '".$tableId."'";
        fwrite($fp,"--deleteStmt-".$deleteStmt."-\n");
        if ($conn->query($deleteStmt) === TRUE ) {
           echo "Success";
           fwrite($fp,"-Success-\n");
        } else {
           echo "Failure";
           fwrite($fp,"-Failure-\n");
        }
     }
  } // if $(conn)
  fclose($fp);
?>
