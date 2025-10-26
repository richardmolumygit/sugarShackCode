<?php
  require "../common_functions.php";
    
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
?>
