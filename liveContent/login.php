<?php
  include_once("common_functions.php");
  fwrite($fp,logTime()."-start-login.php\n");
  $failure="";
  if (isset($_SESSION['failure'])) {
     $failure = "<strong>".$_SESSION['failure']."</strong>";
     fwrite($fp,logTime()."-failure-".$failure."-\n");
  }
  fclose($fp);
  /*
  $failure = ""
  ."-docRoot-".$docRoot
  ."-scriptName-".$scriptName
  ."-log_file-".$log_file
  ."-seperator-".$seperator
  ."-secondPos-".$secondPos
  ."-docRoot-".$docRoot
  ."-scriptName-".$scriptName
  ."-substr-".substr($scriptName,0,$secondPos)
  ."-";
  */
?>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html"; charset=iso-8859-1">
    <meta name="ROBOTS" content="NONE,NOARCHIVE">
    <meta name="GOOGLEBOT" content="NOARCHIVE">
    <title>Sugarshack treats admin page</title>
  </head>
  <body>
    <form name="doLogin" action="do_login.php" method="POST">
      <table width="50%" height="50%">
        <tr><td colspan="4">Login <?= "<font color=\"red\">$failure</font>"; ?></td></tr>
        <tr><td>&nbsp;</td><td>User Name</td><td><input type="text" name="username" id="username" width="50" maxlength="50"></td><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td><td>Password</td><td><input type="password" name="password" id="password" width="50" maxlength="50"></td><td>&nbsp;</td></tr>
        <tr><td colspan="4">&nbsp;</td></tr>
        <tr><td colspan="4" align="center"><input type="submit" value="Login" name="submit" id="submit"></td></tr>
      </table>
    </form>
    <table>
      <tr><td>&nbsp;</td></tr>
      <tr><td>Click <a href="forgot_password.php">here</a> to retrieve password.</td></tr>
      <tr><td>Click <a href="new_account_request.php">here</a> to create an account.</td></tr>
    </table>
  </body
</html>
