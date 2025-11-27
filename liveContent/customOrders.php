<?php
  require "common_functions.php";
  $log_file = "treatBaskets.log";
  $fp = fopen($log_file,'w');

  $sessionId = session_id();
  echo "<!--sessionId-".$sessionId."-->\n";

  $conn = db_connect();

  $numRows = 0;
  if ($conn) {

     $query = "SELECT 
                 id, itemName, imageName, itemName, price, category, description 
                 FROM catalog 
                 WHERE imageName IS NOT NULL AND TRIM(imageName) <> ''
                 ORDER BY category, itemName";
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
        var cakeCnt=0;
        var cookieCnt=0;
        var treatCnt=0;
        var totalCakes = 0;
        var totalCookies = 0;
        var totalTreats = 0;
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
           $category = $row['category'];
           $description = $row['description'];
           echo "           { id: ".$catId;
           echo ", itemName: '".$itemName."'";
           echo ", imageName: '".$imageName."'";
           echo ", price: '".$price."'";
           echo ", category: '".$category."'";
           echo ", description: '".$description."' }";
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
//        alert('loaded');
          addDetails();
          trDeleteId = ''
          for (var i = 0, row; row = tableObj.rows[i]; i++) {
//           alert('row ('+i+') |'+row.innerHTML+'|');
             rowId = row.id;
             if (rowId.substring(0,4) == 'line') {
                col = row.cells;
                td0=col[0].innerHTML;
                td2=col[2].innerHTML;
                td4=col[4].innerHTML;
                allTd = td0+td2+td4
//              alert('allTd ('+allTd.length+') |'+allTd+'|');
                if (allTd.length == 0) {
                   trDeleteId = rowId;
                }
/*
                alert(row.innerHTML);
                tdOut = '';
                tdOut += col[0].id+'|'+col[0].innerHTML+'|\n';
                tdOut += col[2].id+'|'+col[2].innerHTML+'|\n';
                tdOut += col[4].id+'|'+col[4].innerHTML+'|\n';
                alert(tdOut);
*/
             } // if (rowId.substring(0,4) == 'line')
          } // for (var i = 0, row; row = tableObj.rows[i]; i++)
          if (trDeleteId != '') {
/*
             alert('trDeleteId |'+trDeleteId+'|');
             rowToDelete = document.getElementById(trDeleteId);
             tableObj.deleteRow(rowToDelete);
*/
             document.getElementById(trDeleteId).remove();
          }
        }
      </script>
      <table id='mainTable'>
        <tr id='head1'>
          <td colspan="6" style="text-align: center;"><h2>Sugar Shack Treats</h2></td>
        </tr>
        <tr id='head2'>
          <td colspan="6" style="text-align: center;"><h3>Custom Orders</h3></td>
        </tr>
        <tr id='head2' style='border:1px solid #000; border-collapse: collapse'>
          <td sytle='align: left'><b>Cookies</b></td>
          <td><b>Qty</b></td>
          <td sytle='align: left'><b>Cakes</b></td>
          <td><b>Qty</b></td>
          <td sytle='align: left'><b>Treats</b></td>
          <td><b>Qty</b></td>
        </tr>
        <tr id='line0' style='border: 1px'>
          <td id='cookie0'></td>
          <td id='cookieQty0'>
            <input id='cookieInput0' style='width:40px' value=0>
          </td>
          <td id='cake0'></td>
          <td id='cakeQty0'>
            <input id='cakeInput0' style='width:40px' value=0>
          </td>
          <td id='treat0'></td>
          <td id='treatQty0'>
            <input id='treatInput0' style='width:40px' value=0>
          </td>
        </tr>
        <tr id='emailLine'>
          <td colspan="6" style="text-align: center;">Email us for questions at: <a href="mailto:SugarShackTreats@gmail.com">SugarShackTreats@gmail.com</a></td>
        </tr>
        <tr id='spacesAgain'>
          <td colspan="6" style='text-align: center'>&nbsp;</td>
        </tr>
        <tr id='logo'>
          <td colspan="6" style="text-align: center;"><img id='finalLogo' src="images/finalLogoSept2025.jpg"></td>
        </tr>
      </table>
      <script>
        const tableObj = document.getElementById('mainTable');
        const parentWindow = window.parent;
        const rightNavIFrame = parentWindow.document.getElementById('rightNav');
        var insertRowNbr = 4;

        function addDetails() {
//        alert('addDetails');
          saveLine = document.getElementById('line0').innerHTML;
          newLine = document.createElement('tr');
          catItemsArray.forEach(cItem => {
            iCategory = cItem.category;
            if (iCategory == 'cake') {
               totalCakes++;
            } else if(iCategory == 'cookie') {
               totalCookies++;
            } else if(iCategory == 'treat') {
               totalTreats++;
            }
          });
          itemCnt = 0;
          lineNbr = 0;
          catItemsArray.forEach(cItem => {
            itemCnt++;
            itemName = cItem.itemName;
            iCategory = cItem.category;
            cakeId = 'cake'+cakeCnt;
            cookieId = 'cookie'+cookieCnt;
            treatId = 'treat'+treatCnt;
            cakeItem = document.getElementById(cakeId).innerHTML;
            cookieItem = document.getElementById(cookieId).innerHTML;
            treatItem = document.getElementById(treatId).innerHTML;
  
            if (cakeItem != '') {
               cakeCnt++;
            }
            if (cookieItem != '') {
               cookieCnt++;
            }
            if (treatItem != '') {
               treatCnt++;
            }

//          alert('cookieCnt ('+cookieCnt+') cakeCnt ('+cakeCnt+') treatCnt ('+treatCnt+') lineNbr ('+lineNbr+')');
            if ( ( cookieCnt > lineNbr ) || ( cakeCnt > lineNbr ) || ( treatCnt > lineNbr ) ) {
               lineNbr++;
            }
            lineId = 'line'+lineNbr;
            
            tableRow = document.getElementById(lineId);
            if (! tableRow) {
               addRow(lineNbr);
            }
            appendRow(cakeCnt, cookieCnt, treatCnt, itemCnt, iCategory, itemName);
          });
        }

        function addRow(rowNbr) {
//        alert('addRow('+rowNbr+')');
/*
          for (var i = 0, row; row = tableObj.rows[i]; i++) {
             alert('row ('+i+') |'+row.innerHTML+'|');
          }
*/
          newLine = document.getElementById('newLine');
          const newRow = tableObj.insertRow(insertRowNbr);
          const cakeQty = "<input id='cakeInput"+rowNbr+"' style='width:40px' value='0'>";
          const cookieQty = "<input id='cookieInput"+rowNbr+"' style='width:40px' value='0'>";
          const treatQty = "<input id='treatInput"+rowNbr+"' style='width:40px' value='0'>";
          newRow.setAttribute('id','line'+rowNbr);
          const cakeCell = document.createElement("td");
          cakeCell.setAttribute('id','cake'+rowNbr);
          const cakeCellQty = document.createElement("td");
          cakeCellQty.setAttribute('id','cakeQty'+rowNbr);
          cakeCellQty.innerHTML = cakeQty;
          const cookieCell = document.createElement("td");
          cookieCell.setAttribute('id','cookie'+rowNbr);
          const cookieCellQty = document.createElement("td");
          cookieCellQty.setAttribute('id','cookieQty'+rowNbr);
          cookieCellQty.innerHTML = cookieQty;
          const treatCell = document.createElement("td");
          treatCell.setAttribute('id','treat'+rowNbr);
          const treatCellQty = document.createElement("td");
          treatCellQty.setAttribute('id','treatQty'+rowNbr);
          treatCellQty.innerHTML = treatQty;
          newRow.appendChild(cookieCell);
          newRow.appendChild(cookieCellQty);
          newRow.appendChild(cakeCell);
          newRow.appendChild(cakeCellQty);
          newRow.appendChild(treatCell);
          newRow.appendChild(treatCellQty);
          insertRowNbr++;
//        alert('insertRowNbr ('+insertRowNbr+')');
        }

        function appendRow(cakeCnt, cookieCnt, treatCnt, itemCnt, iCategory, itemName) {
//        alert('appendRow('+cakeCnt+', '+cookieCnt+', '+treatCnt+', '+ itemCnt+', '+ iCategory+', '+ itemName+')');
          cakeId = 'cake'+cakeCnt;
          cookieId = 'cookie'+cookieCnt;
          treatId = 'treat'+treatCnt;
          cakeItem = document.getElementById(cakeId);
          cookieItem = document.getElementById(cookieId);
          treatItem = document.getElementById(treatId);
/*
          alert('itemName |'+itemName+'|');
          alert('cakeId |'+cakeId+'|');
          alert('cakeItem.innerHTML |'+cakeItem.innerHTML+'|');
*/
          if (iCategory == 'cake') {
             cakeItem.innerHTML = itemName;
/*
             cakeCnt++;
             alert('cakeItem ('+cakeCnt+') |'+cakeItem.innerHTML+'|');
*/
          }
          if (iCategory == 'cookie') {
             cookieItem.innerHTML = itemName;
/*
             cookieCnt++;
             alert('cookieItem ('+cookieCnt+') |'+cookieItem.innerHTML+'|');
*/
          }
          if (iCategory == 'treat') {
             treatItem.innerHTML = itemName;
/*
             treatCnt++;
             alert('treatItem ('+treatCnt+') |'+treatItem.innerHTML+'|');
*/
          }
        }
  
      </script>
<?php
  fclose($fp);
?>
