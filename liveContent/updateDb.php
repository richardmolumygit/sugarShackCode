<?php
  require "common_functions.php";
  $log_file = "updateDb.log";
  $fp = fopen($log_file,'w');

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
  fwrite($fp,logTime()."begin-GET-\n");
  foreach ($_GET as $id=>$value) {
     echo "<!--id-".$id."-value-".$value."-->\n";
     fwrite($fp,logTime()."id-".$id."-value-".$value."-\n");
  }
  echo "<!--end-GET-->\n";
  echo "<!--begin-POST-->\n";
  fwrite($fp,logTime()."begin-POST-\n");
  foreach ($_POST as $id=>$value) {
     echo "<!--id-".$id."-value-".$value."-->\n";
     fwrite($fp,logTime()."id-".$id."-value-".$value."-\n");
  }
  fwrite($fp,logTime()."end-POST-\n");
  echo "<!--end-POST-->\n";
*/
  echo "<!--fileName-".$fileName."-->\n";
  fwrite($fp,logTime()."fileName-".$fileName."-\n");
  $truncated = 0;
  $updateCnt = 0;
  if (isset($fileName)) {
     $catalogFile = fopen($fileName, "r") or die("Unable to open ".$catalogFileName." file!");
     $conn = db_connect();
     if ($conn) {
        $itemNbr = 0;
        while(($line = fgetcsv($catalogFile)) !== FALSE) {
          $itemNbr += 1; // Headings are on line 1
          if ($itemNbr < 2) {
             $truncateQuery = "TRUNCATE TABLE catalog";
             if ( mysqli_query($conn, $truncateQuery) ) {
                $msg = "catalog table truncated successfully";
                $truncated = 1;
                fwrite($fp,logTime()."msg-".$msg."-\n");
             } else {
                break;
             }
          } else {
             $href = $line[0];
             $name = $line[1];
             $price = $line[2];
             $category = $line[3];
             $description = $line[4];
             $misc = $line[5];
/*
             fwrite($fp,logTime()
              ."href-".$href
              ."-name-".$name
              ."-price-".$price
              ."-category-".$category
              ."-description-".$description
              ."-misc-".$misc
              ."-\n");
*/
             $addRow = "INSERT INTO catalog (id,imageName,itemName,price,category,description) VALUES ('".$itemNbr."','".$href."','".$name."','".$price."','".$category."','".$description."')";
             echo "<!--addRow-".$addRow."-->\n";
//           fwrite($fp,logTime()."addRow-".$addRow."-\n");
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
     fwrite($fp,logTime()."itemNbr-".$itemNbr."-truncated-".$truncated."-updateCnt-".$updateCnt."-\n");
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
