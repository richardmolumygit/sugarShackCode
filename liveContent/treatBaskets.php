<?php
  require "common_functions.php";
  $log_file = "treatBaskets.log";
  $fp = fopen($log_file,'w');

  $sessionId = session_id();
  echo "<!--sessionId-".$sessionId."-->\n";

  $conn = db_connect();

  $numRows = 0;
  if ($conn) {
     // INNER JOIN catalog with shopping cart
     $query = "SELECT 
                 id, itemName, imageName, itemName, price, description 
                 FROM catalog 
                 WHERE imageName IS NOT NULL AND TRIM(imageName) <> ''";
     echo "<!--query-".$query."-->\n";
     fwrite($fp,logTime()."sessionId-".$sessionId."-\n");
     fwrite($fp,logTime()."query-".$query."-\n");

     $queryResult = $conn->query($query);
     $queryResult1 = $conn->query($query);
     $numRows = $queryResult->num_rows;
     echo "<!--numRows-".$numRows."-->\n";
     fwrite($fp,logTime()."numRows-".$numRows."-\n");
  } // if $(conn)
?>
      <style>
       img {
         width: 40%; /* Sets the image width to 50% of its parent container */
         height: auto; /* Maintains aspect ratio */
       }
      </style>
      <script>
        const cookieSelect = document.getElementById('cookies');
        nbrRows = <?= $numRows; ?>;
        var catItemsArray = [
<?php
        $rowNbr = 0;
        while ($row = $queryResult->fetch_assoc()) {
           $rowNbr += 1;
           $catId = $row['id'];
           $itemName = $row['itemName'];
           $imageName = $row['imageName'];
           $price = floatval($row['price']);
           $description = $row['description'];
           echo "           { id: ".$catId;
           echo ", itemName: ".$itemName;
           echo ", imageName: ".$imageName;
           echo ", price: '".$price."'";
           echo ", description: ".$description." }";
           if ($rowNbr < $numRows) {
              echo ",";
           }
           echo "\n";
        } // while ($row = $queryResult->fetch_assoc())
?>
        ];
        const formatterUSD = new Intl.NumberFormat('en-US', {
          style: 'currency',
          currency: 'USD'
        });
        window.onload = function() {
          alert(alertList);
        }
      </script>
      <table id='mainTable'>
        <tr id='head1'>
          <td colspan="5" style="text-align: center;"><h2>Sugar Shack Treats</h2></td>
        </tr>
        <tr id='head2'>
          <td colspan="5" style="text-align: center;"><h3>Custom Simple Treat Baskets $35</h3></td>
        </tr>
	<tr id='head2'><td colspan="5"></td></tr>
        <!--tr id='head2'>
          <td colspan="5" style="text-align: center;">Pick 12 cookies, can be an assortment.  Pick one cake flavor for a loaf pan. Under treats choose between 3 cakecikes or a browerss and flavors of cakcicles. All backets include 3 pretzel sticks</td>
        </tr-->
	<tr id='dataHead1'>
	  <td>
            <label for='cookies'>Cookies</label>
            <select id='cookies' name='cookies'></select>
          </td>
          <td>
            <label for='cakes'>Cakes (6x2 cake loaf)</label>
            <select id='cakes' name='cakes'>
            </select>
          </td>
          <td>
            <label for='cookies'>Treats</label>
            <select id='cookies' name='cookies'>
            </select>
          </td>
        </tr>
	<tr id='dataHead2'>
	  <td>Pick 12 cookies,</td>
	  <td>Pick one cake flavor</td>
	  <td>Choose between 3 cakesicles</td>
        </tr>
	<tr id='dataHead3'>
	  <td>can be an assortment</td>
	  <td> </td>
	  <td>or 1 brownie</td>
        </tr>
	<tr id='dataHead4'>
	  <td colspan="5" style="text-align: center">All baskets include 3 pretzel sticks</td>
        </tr>
	<tr id='spaces'><td colspan="5"></td></tr>
        <tr id='emailLine'>
          <td colspan="5" style="text-align: center;">Email us for questions at: <a href="mailto:SugarShackTreats@gmail.com">SugarShackTreats@gmail.com</a></td>
        </tr>
	<tr id='spaces'><td colspan="5"></td></tr>
        <tr id='spacesAgain'>
          <td colspan="5" style='text-align: center'>&nbsp;</td>
        </tr>
        <tr id='logo'>
          <td colspan="5" style="text-align: center;"><img id='finalLogo' src="images/finalLogoSept2025.jpg"></td>
        </tr>
      </table>
      <script>
        const tableObj = document.getElementById('mainTable');
        const parentWindow = window.parent;
        const rightNavIFrame = parentWindow.document.getElementById('rightNav');

        function PopulateTables() {
          addCookies();
        }

        function addCookies() {
/*
           echo "           { id: ".$catId;
           echo ", itemName: ".$itemName;
           echo ", imageName: ".$imageName;
           echo ", price: '".$price."'";
           echo ", description: ".$description." }";
*/

          cookieSelect.innerHTML = '';
          alertList = '';
          catItemsArray.forEach(cItem => {
            itemName = cItem.itemName;
            alertList += itemName + '\n';
            const option = document.createElement('option');
            option.value = itemName;
            option.textContent = itemName;
            cookieSelect.appendChild(option);
          });
        }
  
      </script>
<?php
  fclose($fp);
?>
