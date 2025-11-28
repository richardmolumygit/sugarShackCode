<?php
  require "common_functions.php";

  $log_file = "cakes.log";
  $fp = fopen($log_file,'w');

  $sessionId = session_id();
  echo "<!--sessionId-".$sessionId."-->\n";

  $conn = db_connect();

  $numRows = 0;
  if ($conn) {
     // INNER JOIN catalog with shopping cart
     $query = "SELECT * FROM catalog
               WHERE category = 'cake'
               AND imageName IS NOT NULL AND TRIM(imageName) <> ''";
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
      <table>
        <tr>
          <td colspan="2" style="text-align: center;"><h2>Sugar Shack Treats</h2></td>
        </tr>
        <tr>
          <td id='tdHead1' style="text-align: center;"></td>
          <td id='tdHead2' style="text-align: center;"></td>
        </tr>
        <tr>
<?php
  $colNbr = 0;
  $numRows = 0;
  $rowNbr = 0;
  $head1='';
  $head2='';
  while ($row = $queryResult->fetch_assoc()) {
     $rowNbr += 1;
     $catId = $row['id'];
     $imageName = $row['imageName'];
     $itemName = $row['itemName'];
     $price = floatval($row['price']);
     $description = $row['description'];
     fwrite($fp,logTime()."itemName-".$itemName."-\n");
     if ($rowNbr == 1) { $head1=$itemName; }
     if ($rowNbr == 2) { $head2=$itemName; }
     if ($colNbr == 0) {
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
     } else {
       $colNbr = 0;
?>
          <td>
            <a href="javascript:changePages('<?= $catId; ?>')" class='image-button-container'>
              <img id='image<?= $catId; ?>' src='images/<?= $imageName; ?>' alt='<?= $itemName ?>' class='button-image' width='200' height='200'>
              <div class="overlay">
                <div id='description<?php echo $catId; ?>' class="overlay-text"><?= $description ?></div>
              </div>
              <input type='hidden' id='unitPrice<?php echo $catId; ?>' value='4.50'>
            </a>
          </td>
<?php
     }
     $colNbr += 1;
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
        window.onload = function() {
          var tdHead1 = document.getElementById('tdHead1');
          var tdHead2 = document.getElementById('tdHead2');
          head1='<?= $head1 ?>';
          head2='<?= $head2 ?>';
          if (head1 != '') { tdHead1.innerHTML = head1; }
          if (head2 != '') { tdHead2.innerHTML = head2; }
        }
      </script>
