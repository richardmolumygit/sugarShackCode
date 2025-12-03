<?php
  require "common_functions.php";

  $log_file = "mainPage.log";
  $fp = fopen($log_file,'w');

  $sessionId = session_id();
  echo "<!--sessionId-".$sessionId."-->\n";

  $conn = db_connect();

  $numRows = 0;
  if ($conn) {
     // INNER JOIN catalog with shopping cart
     $query = "SELECT * from catalog 
               WHERE imageName 
               IS NOT NULL AND TRIM(imageName) <> ''";
     echo "<!--query-".$query."-->\n";

     $queryResult = $conn->query($query);
     $numRows = $queryResult->num_rows;
     echo "<!--numRows-".$numRows."-->\n";
     fwrite($fp,logTime()."sessionId-".$sessionId."-\n");
     fwrite($fp,logTime()."query-".$query."-\n");
     fwrite($fp,logTime()."numRows-".$numRows."-\n");
  } // if $(conn)
?>

      <link rel="stylesheet" type="text/css" href="css/overlay.css">
      <script src=js/changePages.js></script>
      <table id='mainTable' border=1 sytle='border-collapse: collapse'>
        <col style="width: 250px;">
        <col style="width: 250px;">
        <tr>
          <td colspan="2" style="text-align: center;"><h2>Sugar Shack Treats</h2></td>
        </tr>
        <tr>
          <td id='tdHead20' style="text-align: center;"></td>
          <td id='tdHead21' style="text-align: center;"></td>
        </tr>
        <tr>
<?php
  $colNbr = 0;
  $numRows = 0;
  $rowNbr = 0;
  $trRowNbr = 2;
  $headingsArray = []; // Initialize emmpty array
  while ($row = $queryResult->fetch_assoc()) {
     $rowNbr += 1;
     $catId = $row['id'];
     $imageName = $row['imageName'];
     $itemName = $row['itemName'];
     $price = floatval($row['price']);
     $description = $row['description'];
     $index = "tdHead" . $trRowNbr . $colNbr;
     $headingsArray[$index] = $itemName;
//   ${'head' . $trRowNbr . $colNbr} = $itemName;
     fwrite($fp,logTime()."index -".$index."-head".$trRowNbr.$colNbr." = |".$itemName."|\n");
/*
     if ($rowNbr == 1) { $head20=$itemName; }
     if ($rowNbr == 2) { $head21=$itemName; }
*/
?>
          <td style="text-align: center;">
            <a href="javascript:changePages('<?= $catId; ?>')" class='image-button-container'>
              <img id='image<?= $catId; ?>' src='images/<?= $imageName; ?>' alt='<?= $itemName ?>' class='button-image' width='200' height='200'>
              <div class="overlay">
                <div id='description<?php echo $catId; ?>' class="overlay-text"><?= $description ?></div>
              </div>
              <input type='hidden' id='unitPrice<?php echo $catId; ?>' value='<?= $price ?>'>
            </a>
          </td>
<?php
     if ($colNbr == 0) {
       $colNbr++;
     } else {
       $colNbr = 0;
       $trRowNbr++;
?>
        </tr>
        <tr>
          <td id='tdHead<?= $trRowNbr ?>0' style="text-align: center;"></td>
          <td id='tdHead<?= $trRowNbr ?>1' style="text-align: center;"></td>
        </tr>
        <tr>
<?php
     }
//   $colNbr += 1;
  } // while ($row = $queryResult->fetch_assoc())
?>
        </tr>
        <tr>
          <td style="text-align: center;">&nbsp;</td>
          <td style="text-align: center;">&nbsp;</td>
        </tr>
        <!--TR_EMPTY-->
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" style="text-align: center;">Email us for questions at: <a href="mailto:SugarShackTreats@gmail.com">SugarShackTreats@gmail.com</a></td>
        </tr>
        <tr>
          <td colspan="2" style="text-align: center;"><img id='finalLogo' src="images/finalLogoSept2025.jpg"></td>
        </tr>
      </table>
      <script>
        const tableObj = document.getElementById('mainTable');
        window.onload = function() {
<?php
  foreach ($headingsArray as $id=>$value) {
//  if (substr($id,-1) == "1") {
//     fwrite($fp,logTime()."lastChar-".substr($id,-1)."-\n");
//  }
    fwrite($fp,logTime()."id-".$id."-value-".$value."-\n");
    echo "          document.getElementById('".$id."').innerHTML = '".$value."';\n";
  }
?>
        }
      </script>

