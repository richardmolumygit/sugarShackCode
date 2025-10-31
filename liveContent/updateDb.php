<?php
  require "common_functions.php";
  $fileName="./catalog.csv";
/*
  unset($fileName);
  unset($password);
  if (isset($_POST['fileName'])) {
     $fileName = $_POST['fileName'];
  } else if (isset($_GET['fileName'])) {
     $fileName = $_GET['fileName'];
  }
  if (isset($_POST['password'])) {
     $password = $_POST['password'];
  } else if (isset($_GET['password'])) {
     $password = $_GET['password'];
  }
  echo "<!--begin-GET-->\n";
  foreach ($_GET as $id=>$value) {
     echo "<!--id-".$id."-value-".$value."-->\n";
  }
  echo "<!--end-GET-->\n";
  echo "<!--begin-POST-->\n";
  foreach ($_POST as $id=>$value) {
     echo "<!--id-".$id."-value-".$value."-->\n";
  }
  echo "<!--end-POST-->\n";
*/
  echo "<!--fileName-".$fileName."-->\n";
  $updateCnt = 0;
  if (isset($fileName)) {
     $catalogFile = fopen($fileName, "r") or die("Unable to open ".$catalogFileName." file!");
     $conn = db_connect();
     if ($conn) {
        $itemNbr = 0;
        while(($line = fgetcsv($catalogFile)) !== FALSE) {
          $itemNbr += 1; // Heading are on line 1
          if ($itemNbr < 2) {
             $truncateQuery = "TRUNCATE TABLE catalog";
             if ( mysqli_query($conn, $truncateQuery) ) {
                $msg = "catalog table truncated successfully";
                fwrite($fp,logTime()."-msg(".$msg.")\n");
             } else {
                break;
             }
          } else {
             $href = $line[0];
             $name = $line[1];
             $price = $line[2];
             $description = $line[3];
             $addRow = "INSERT INTO catalog (`id`,`imageName`,`itemName`,`price`,`description`) VALUES ('".$itemNbr."','".$href."','".$name."','".$price."','".$description."')";
             echo "<!--addRow-".$addRow."-->\n";
             if ( mysqli_query($conn, $addRow) ) {
                $updateCnt += 1;
             } else {
                $msg = mysqli_error($conn);
                fwrite($fp,logTime()."-msg(".$msg.")\n");
                break;
             } // if ( mysqli_query($conn, $addRow) )
          } // if ($itemNbr > 1)
        } // while(($line = fgetcsv($catalogFile)) !== FALSE)
     } // if ($conn) 
     echo "<!--itemNbr-".$itemNbr."-->\n";
  }
  fclose($fp);
  echo "<html>\n";
  echo "  <body>\n";
  echo "    <form action='admin.php' method='post' enctype='multipart/orm-data'>";
  if ($updateCnt > 1) {
     echo "<h4>Added ".$updateCnt." rows!</h4>";
  } else {
     echo "<h1>Error updating database</h1>";
  }
?>
    <input type="submit" name"Submit">
  </body>
</html>
