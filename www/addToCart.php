<?php
  require "../common_functions.php";
/*
  unset($username);
  unset($password);
  if (isset($_POST['username'])) {
     $username = $_POST['username'];
  } else if (isset($_GET['username'])) {
     $username = $_GET['username'];
  }
  if (isset($_POST['password'])) {
     $password = $_POST['password'];
  } else if (isset($_GET['password'])) {
     $password = $_GET['password'];
  }

  fwrite($fp,logTime()."begin-POST-values\n");
  foreach ($_POST as $id=>$value) {
     fwrite($fp,logTime()."id<".$id.">value<".$value.">\n");
  }
  fwrite($fp,logTime()."end-POST-values\n");
  header('Location: http://127.0.0.1/alertOne/main.php');
*/
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

  if (isset($username) && isset($password)) {
     $conn = db_connect();
     if ($conn) {
        $sql = "SELECT isAdmin, verified_flag, password, password_tmp from users where username = '".$username."'";
        if ($result = mysqli_query($conn, $sql)) {
           fwrite($fp,logTime()."-sql-".$sql."\n");
           $cntr=0;
           $msg = "";
           while ($row = mysqli_fetch_assoc($result)) {
/*
              $passwordKey = $row['passwordKey'];
              fwrite($fp,logTime()."-password(".$password.")row['password_tmp'](".$row['password_tmp'].")\n");

              fwrite($fp,logTime()."-passwordKey($passwordKey)\n");
              fwrite($fp,logTime().sha1($passwordKey.$password)."\n");
              fwrite($fp,logTime().sha1($passwordKey.$row['password'])."\n");
*/  
              $passwordRow = $row['password'];
              $passwordTmp = $row['password_tmp'];
  
              echo "<--passwordRow-".$passwordRow."--><br>";
              echo "<--passwordTmp-".$passwordTmp."--><br>";

              fwrite($fp,logTime()."-password(".$password.")row['password_tmp'](".$row['password_tmp'].")\n");
              if (($row['password'] == $password) || ($row['password_tmp'] == $password)) {
                 fwrite($fp,logTime()."-row['verified_flag'](".$row['verified_flag'].")\n");
                 if ($row['verified_flag'] == "Y") {
                    fwrite($fp,logTime()."-session_start()-\n");
                    session_start();
                    $_SESSION['isActive'] = session_id();
                    $_SESSION['userId'] = $username;
                    if ($row['isAdmin'] == "1") {
                       $_SESSION['isAdmin'] = true;
                       fwrite($fp,logTime()."-isAdmin-true\n");
                    }
                    echo "password_tmp: " . $row["password_tmp"];
                    fwrite($fp,logTime()."isActive-".$_SESSION['isActive']."-session_id()-".session_id()."-\n");
                    $update = "update users set last_access_date = CURRENT_TIMESTAMP where username = '".$username."'";
                    fwrite($fp,logTime()."-update-".$update."-\n");
                    $result = mysqli_query($conn, $update);
                    fwrite($fp,logTime()."-result-".$result."-\n");
                    fwrite($fp,logTime()."-Location:main.php-\n");
                    fclose($fp);
                    if ($passwordRow == $password) {
                       header("Location:main.php");
                    } else {
                       $_SESSION['userId'] = $username;
                       header("Location:changePassword.php");
                    }
                    die();
                 } else {
                    $msg = $username." has not been activated yet!";
                    fwrite($fp,logTime()."-msg(".$msg.")\n");
                 } // if ($row['verified_flag'] == "Y")
              } else {
                 $msg = "Invalid password for ".$username;
                 fwrite($fp,logTime()."-msg(".$msg.")\n");
              } // if ($row['password'] == $password)
              fwrite($fp,logTime()."-cntr inside loop(".$cntr.")\n");
              $cntr++;
           } // while( $row=mysql_fetch_array($result) )
        } // if ($result = mysqli_query($conn, $sql)) 
     } // if ($conn)
     fwrite($fp,logTime()."-cntr(".$cntr.")msg(".$msg.")\n");
     if (($cntr > 0) && ($msg == "")) {
         $msg = "User has not been verified yet!";
         fwrite($fp,logTime()."-msg(".$msg.")\n");
         tryAgain($username,$msg);
     } else if ($cntr > 0) {
         fwrite($fp,logTime()."-msg(".$msg.")\n");
         tryAgain($username,$msg);
     } else {
         $msg = "Username '".$username."' not found!";
         fwrite($fp,logTime()."-msg(".$msg.")\n");
         tryAgain($username,$msg);
     }
  } else {
     fwrite($fp,logTime()."-msg(".$msg.")\n");
     tryAgain($username,$msg);
  } // if (isset($username) && isset($password))
  fclose($fp);
?>
