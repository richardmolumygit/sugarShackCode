<?php
  require "../common_functions.php";

  $sessionId = session_id();
  echo "<!--sessionId-".$sessionId."-->\n";
    
  fwrite($fp,logTime()."begin-POST-values\n");
  echo "<!--begin-POST-values-->\n";
  foreach ($_POST as $id=>$value) {
     fwrite($fp,logTime()."id<".$id.">value<".$value.">\n");
     echo "<!--id-".$id."-value-".$value."-><br>\n";
  }
  echo "<!--end-POST-values-->\n";
  echo "<!--begin-GET-values-->\n";
  foreach ($_GET as $id=>$value) {
     fwrite($fp,logTime()."id<".$id.">value<".$value.">\n");
     echo "<!--id-".$id."-value-".$value."-><br>\n";
  }
  echo "<!--end-GET-values-->\n";
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
  echo "<!--radioChoice-".$radioChoice."-->\n";
  echo "<!--itemNbr-".$itemNbr."-->\n";
  echo "<!--qtyInput-".$qtyInput."-->\n";
  $conn = db_connect();
  if (empty($radioChoice)) {
     echo "<!--radioChoice-empty-->\n";
  } elseif (empty($qtyInput)) {
     echo "<!--qtyInput-empty-->\n";
  }
  if (isset($radioChoice)) {
     echo "<!--radioChoice-isset-".$radioChoice."-->\n";
  }
  $qty='';
  if ($conn) {
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
        $insertStmt = "INSERT INTO shopingcart (tableId, cartId, itemNbr, quantity) VALUES (NULL,'".$sessionId."','".$itemNbr."','".$qty."')";
        echo "<!--insertStmt-".$insertStmt."-->\n";
        if ($conn->query($insertStmt) === TRUE ) {
           echo "<!--Sucess!-->\n";
        } else {
           echo "<!--Failure-->\n";
        }
     }
  } // if $(conn)
  echo "<!--https://rich-molumby.fwh.is/www/-->\n";
?>
<script>
  window.location.replace('https://rich-molumby.fwh.is/www/');
</script>
