<?php
  require "common_functions.php";
# session_start();
  $log_file = "admin.log";
  $fp = fopen($log_file,'w');
  fwrite($fp,logTime()."admin.php\n");
  fwrite($fp,logTime()."begin-SESSION-values\n");
  unset ($isActive);
  if (isset($_SESSION['isActive'])) {
     $isActive=$_SESSION['isActive'];
  } // if (isset($_SESSION['isActive']))
  foreach ($_SESSION as $id=>$value) {
     fwrite($fp,logTime()."id<".$id.">value<".$value.">\n");
  }
  fwrite($fp,logTime()."end-SESSION-values\n");
  if (isset($isActive)) {
     fwrite($fp,logTime()."isActive-".$isActive."-\n");
  } else { //if (isset($isActive)) {
     $isActive='NO';
     fwrite($fp,logTime()."isActive-IS NOT SET-\n");
  } // if (isset($isActive)) {
  fclose($fp);
?>
<!DOCTYPE html>
<html>

  <script>
     isActive='<?= $isActive ?>';
     if (isActive == 'NO') {
        window.location.href = "login.php";
     } // if (isActive == 'NO')
     
  </script>

  <body>

    <form action="stage.html" method="post" enctype="multipart/form-data">
      <br/><input type="submit" value="User Page">
    </form>

    <form action="updateDb.html" method="post" enctype="multipart/form-data">
      <br/><input type="submit" value="Synchronize DB with CSV">
      </form>

  </body>
</html>
