<?php
  require "common_functions.php";
  $log_file = "admin.log";
  $fp = fopen($log_file,'w');

  fwrite($fp,logTime()."admin.php\n");
  fclose($fp);
?>
<!DOCTYPE html>
<html>
<body>

<form action="stage.html" method="post" enctype="multipart/form-data">
  <br/><input type="submit" value="User Page">
</form>

<form action="updateDb.html" method="post" enctype="multipart/form-data">
  <br/><input type="submit" value="Synchronize DB with CSV">
</form>

</body>
</html>
