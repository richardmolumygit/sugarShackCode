<?php
  include_once("common_functions.php");
  if (isActiveSession()) {
     fwrite($fp,logTime()."-main.php-isActive-true\n");
  } else {
     fwrite($fp,logTime()."-Redirect to login.php-\n");
     fclose($fp);
     header("Location: login.php");
  }
?>
<html>
  <head>
    <title>Mom's Alert One Fund > Main Page</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  </head>
  <body style="font-family: Verdan,Arial,Helvetica">
    <table width="95%" align="center" cellpadding="10" cellspacing="2">
      <tr>
        <td valign="top"><!--Company Photo--></td>
        <td width="100%" height="400" rowspan="2" valign="top" style="border: dotted 2px #000">
          <center><h2>Main Page</h2></center><br />
<?php
  if (isset($isAdmin) && ($isAdmin !== false)) {
     echo "          <a href=\"admin.php\">Admin</a><br />\n";
  }
?>
          <a href="changePassword.php">Change Password</a><br />
          <a href="makePayment.php">Make Payment</a><br />
          <a href="viewHistory.php">View History</a><br />
          <a href="logout.php">Logoff</a>
        </td>
      </tr>
    </table>
  </body>
</html>
<?php
  fwrite($fp,logTime()."-end-main.txt\n");
  fclose($fp);
?>