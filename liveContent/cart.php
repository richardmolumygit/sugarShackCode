<?php
  require "common_functions.php";
  $log_file = "cart.log";
  $fp = fopen($log_file,'w');

  $sessionId = session_id();
  echo "<!--sessionId-".$sessionId."-->\n";

  $conn = db_connect();

  $numRows = 0;
  if ($conn) {
     // INNER JOIN catalog with shopping cart
     $query = "SELECT 
               c.id, c.imageName, c.itemName, c.price, c.description, 
               s.quantity, s.cartId, s.tableId
               FROM catalog c 
               INNER JOIN shoppingCart s 
               ON c.id = s.itemNbr
               WHERE s.cartid = '".$sessionId."'";
     echo "<!--query-".$query."-->\n";
     fwrite($fp,logTime()."sessionId-".$sessionId."-\n");
     fwrite($fp,logTime()."query-".$query."-\n");

     $queryResult = $conn->query($query);
     $queryResult1 = $conn->query($query);
     $numRows = $queryResult->num_rows;
     echo "<!--numRows-".$numRows."-->\n";
  } // if $(conn)
?>
      <style>
       img {
         width: 40%; /* Sets the image width to 50% of its parent container */
         height: auto; /* Maintains aspect ratio */
       }
      </style>
      <script src="https://www.paypal.com/sdk/js?client-id=AWLq1jpoQe05jZZ2YCg7DKlNPfNJ8XM4Hx3m2TDRqYfkEIYvQjSBYMiDNk8jmlZKxg7EgdFamNLRbRLY&currency=USD&debug=true"></script>
      <script>
        nbrRows = <?= $numRows; ?>;
        var cartItemsArray = [
<?php
        $rowNbr = 0;
        while ($row = $queryResult->fetch_assoc()) {
           $rowNbr += 1;
           $catId = $row['id'];
           $imageName = $row['imageName'];
           $itemName = $row['itemName'];
           $price = floatval($row['price']);
           $description = $row['description'];
           $quantity = $row['quantity'];
           $cartId = $row['cartId'];
           $tableId = $row['tableId'];
           echo "           { id: ".$rowNbr;
           echo ", tableId: ".$tableId;
           echo ", name: '".$itemName."'";
           echo ", quantity: ".$quantity;
           echo ", unit_amount: ".$price." }";
           if ($rowNbr < $numRows) {
              echo ",";
           }
           echo "\n";
        } // while ($row = $queryResult->fetch_assoc())
?>
        ];
        window.onload = function() {
          showTotalPrice();
        }
        const formatterUSD = new Intl.NumberFormat('en-US', {
          style: 'currency',
          currency: 'USD'
        });
      </script>
      <table id='mainTable'>
        <tr id='head1'>
          <td colspan="5" style="text-align: center;"><h2>Sugar Shack Treats</h2></td>
        </tr>
<?php
  $displayId=0;
  $arrayId=0;
  if ($numRows > 0) {
?>
        <tr id='head2'>
          <td style='text-align: left'>Item</td>
          <td style='text-align: left'>Quantity</td>
          <td style='text-align: left'>Price</td>
          <td style='text-align: left'>Total</td>
          <td style='text-align: left'>&nbsp;</td>
        </tr>
<?php
        while ($row = $queryResult1->fetch_assoc()) {
//         print_r($row);
           $catId = $row['id'];
           $imageName = $row['imageName'];
           $itemName = $row['itemName'];
           $price = floatval($row['price']);
           $description = $row['description'];
           $quantity = $row['quantity'];
           $cartId = $row['cartId'];
           $tableId = $row['tableId'];
echo "<!--price-".$price."-quantity-|".$quantity."|-->\n";
/*
           if (is_numeric($price)) {
              echo "<!--price is numeric-->\n";
           } else {
              $price = 0;
           }
*/
// Why do I have to do this (otherwise get non-numeric error
           if (is_numeric($quantity)) {
//            echo "<!--quantity is numeric-->\n";
              $total = $price * $quantity;
           } else {
              $total = $price;
           }
//         echo "<!--tableId-".$tableId."-quantity-".$quantity."-cartId-".$cartId."-->\n";
           if ($cartId = $sessionId) {
              echo "<!--catId-".$catId."-itemName-".$itemName."-price-".$price."-imageName-".$imageName."-description-".$description."-->\n";
//            echo "<!--tableId-".$tableId."-quantity-".$quantity."-cartId-".$cartId."-->\n";
              $displayId += 1;
?>
        </tr>
        <tr id='catItem<?= $displayId; ?>'>
          <td id='cartItemName<?= $displayId; ?>' style='text-align: left'><?= $itemName; ?></td>
          <td style='text-align: left; vertical-align: top'>
            <select id='qtyInput<?= $displayId; ?>' name='qtyInput<?= $displayId; ?>' onChange="changeTotal('<?= $displayId;?>')">
<?php
//echo "<!--quantity-".$quantity."-->\n";
              $qty=0;
              for($qty=0;$qty<15;$qty++) {
//echo "<!--qty-".$qty."-->\n";
                $out = $qty;
                if ($qty == 12) { $out = "1 dozen"; }
                if ($qty == 13) { $out = "2 dozen"; }
                if ($qty == 14) { $out = "1 dozen"; }
                echo "              ";
                if ($out == $quantity) {
                   echo "<option value='".$out."' selected>".$out."</option>\n";
                } else {
                   echo "<option value='".$out."'>".$out."</option>\n";
                }
              } // for($qty=0;$qty<=15;$qty++)
?>
            </select>
          </td>
          <td style='text-align: left' id='price<?= $displayId ?>' name='price<?= $displayId ?>'>$<?= $price; ?></td>
          <td style='text-align: right' id='total<?= $displayId ?>' name='total<?= $displayId ?>'>$<?= $total; ?></td>
          <td style='text-align: right' id='delete_<?= $displayId ?>' name='delete_<?= $displayId ?>' onclick='deleteCartItem(this)'>Delete</td>
          <td style='display: none' id='tableId<?= $displayId ?>'><?= $tableId ?></td>
        </tr>
<?php
             $arrayId += 1;
           } // if ($cartId = $sessionId)
        } // ($row = $queryResult1->fetch_assoc())
?>
        <tr id='totals'>
          <td colspan="2" style='text-align: right'>&nbsp;</td>
          <td style='text-align: left'>Total</td>
          <td colspan='2' id='totalPrice' name='totalPrice' style='text-align: left'>&nbsp;</td>
        </tr>
        <tr id='spaces'>
          <td colspan="5" style='text-align: center'>&nbsp;</td>
        </tr>
        <tr id='payPal-button'>
          <td colspan="5" style='text-align: center'><div id="paypal-button-container"></div></td>
        </tr>
<?php
  } else {
?>
        <tr id='emptyCart'>
          <td colspan="5" style='text-align: center'><h2>Your cart is empty</h2></td>
        </tr>
<?php
  }
?>
        <tr id='emailLine'>
          <td colspan="5" style="text-align: center;">Email us for questions at: <a href="mailto:SugarShackTreats@gmail.com">SugarShackTreats@gmail.com</a></td>
        </tr>
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
  
        // Calculate total
        var totalAmount = cartItemsArray.reduce((sum, item) => sum + item.unit_amount * item.quantity, 0);
        paypal.Buttons({
          // Create the order on the server (or here in client-side demo)
          createOrder: function(data, actions) {
            return actions.order.create({
              purchase_units: [{
                amount: {
                  currency_code: "USD",
                  value: totalAmount.toFixed(2),
                  breakdown: {
                    item_total: { currency_code: "USD", value: totalAmount.toFixed(2) }
                  }
                },
                items: cartItemsArray.map(item => ({
                  name: item.name,
                  unit_amount: { currency_code: "USD", value: item.unit_amount.toFixed(2) },
                  quantity: item.quantity
                }))
              }]
            });
          },

          // Capture the order when the buyer approves the transaction
          onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
              console.log('Transaction completed by ' + details.payer.name.given_name);
              alert('Payment successful! Thank you, ' + details.payer.name.given_name);
              // TODO: Send details to your server for fulfillment
            });
          },

          onError: function(err) {
            console.error('PayPal Checkout Error', err);
          }
 
        }).render('#paypal-button-container');

        document.getElementById('confirmPay').addEventListener('click', () => {
          // When user clicks your button, trigger the PayPal flow
          paypalButtons.click(); // this call works if library supports it
        });

        function deleteCartItem(tdItem) {
          tdNbr = tdItem.id.split('_')[1];
          cartStr = 'tableId' + tdNbr;
          cartId = document.getElementById(cartStr).innerHTML;
          trParent = tdItem.parentElement 	// Get tr for this td
          tableIdx = trParent.rowIndex;		// Get row index for this td
          di = cartItemsArray[tdItem];
          cartItemsArray.splice(tdItem,1);
          tableObj.deleteRow(tableIdx);
          nbrRows = tableObj.rows.length;
          showTotalPrice();

          // Update shopping cart
  
          var xmlhttp = new XMLHttpRequest();
          response = ''
          xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              response += this.responseText;
            }
            response += '|'+this.readyState
          };
          xmlhttp.open("GET", "deleteFromCart.php?tableId=" + cartId, true);
          xmlhttp.send();
          nbrItems = 0;

          // See if the cart is empty and then refresh page if it is.
          trRows = tableObj.querySelectorAll('tr');
          rowIds = '';
          trRows.forEach(row => {
            rowId = row.id;
            if (rowId.substring(0,7) == 'catItem') {
               nbrItems += 1;
            } // if (trId.substring(0,7) == 'catItem')
          }); // trRows.forEach(tow =>
          if (nbrItems == 0) {
             rightNavIFrame.src = 'cart.php';
          } // if (nbrRows == 0)

          // Recompute total amount
          totalAmount = cartItemsArray.reduce((sum, item) => sum + item.unit_amount * item.quantity, 0);
//        alert('totalAmount ('+totalAmount+')');
  
          cartItemsArray.forEach(cItem => {
            cName = cItem.name;
            cQty = cItem.quantity;
            cAmt = cItem.unit_amount;
//          alert('cName |'+cName+'| cQty |'+cQty+'| cAmt (' + cAmt + ')');
          });
  
        } // function deleteCartItem(deleteNbr)

        function showTotalasMoney(totalId,newTotal) {
          document.getElementById(totalId).innerHTML = formatterUSD.format(newTotal);
        }
        function removeLeadingChar(input) {
          return input.substring(1,input.length);
        }
        function showTotalPrice() {
          totalPriceVal = document.getElementById('totalPrice');
          totalPrice = 0;
          for (i=1;i<=nbrRows;i++) {
             priceStr = 'price'+i;
             totalStr = 'total'+i;
             qtyInput = 'qtyInput'+i;
//           alert('showTotalPrice priceStr |'+priceStr+'| totalStr |'+totalStr+'| totalPrice ('+totalPrice+')');
             // When an item is deleted, it won't be available anymore
             try {
               mySelect = document.getElementById(qtyInput).value;
               priceVal = removeLeadingChar(document.getElementById(priceStr).innerHTML);
               totalVal = removeLeadingChar(document.getElementById(totalStr).innerHTML);
               totalVal = mySelect * priceVal;
               totalPrice = totalPrice + parseFloat(totalVal);
 //            alert('showTotalPrice qty ('+mySelect+') priceVal ('+priceVal+') totalPrice ('+totalPrice+')');
               showTotalasMoney(priceStr,priceVal)
               showTotalasMoney(totalStr,totalVal);
               showTotalasMoney('totalPrice',totalPrice);
             } catch (error) {
             }
          }
          showTotalasMoney('totalPrice',totalPrice);
//        alert('showTotalPrice totalPrice ('+totalPrice+')');
        }

        function changeTotal(lineNbr) {
//         alert('changeTotal('+lineNbr+')');
           cartItemName = 'cartItemName'+lineNbr;
//         alert('cartItemName |'+cartItemName+'|');
           priceId = 'price'+lineNbr;
           qtyInput = 'qtyInput'+lineNbr;
           totalId = 'total'+lineNbr;
           var textItem = document.getElementById(cartItemName).innerHTML;
           var mySelect = document.getElementById(qtyInput).value;
           var priceStr = document.getElementById(priceId).innerHTML;
           // chop off first character of the string (The $)
           priceAmt = removeLeadingChar(document.getElementById(priceId).innerHTML);
           newTotal = priceAmt * mySelect;
  
           cartItemsArray.forEach(cItem => {
             cName = cItem.name;
             cQty = cItem.quantity;
             cAmt = cItem.unit_amount;
             console.info('cName |'+cName+'| cQty |'+cQty+'| cAmt (' + cAmt + ')');
             totalPrice = 0;
             if (cName == textItem) {
                cItem.quantity = mySelect;
             }
//           alert('cName |'+cItem.name+'| quantity |'+cItem.quantity+'| unit_amount |'+cItem.unit_amount+'| totalPrice ('+totalPrice+')');
           });
           totalAmount = cartItemsArray.reduce((sum, item) => sum + item.unit_amount * item.quantity, 0);

           cartItemsArray.forEach(cItem => {
             cName = cItem.name;
             console.info('after-cName |'+cItem.name+'| quantity |'+cItem.quantity+'| unit_amount |'+cItem.unit_amount+'| totalAmount ('+totalAmount+')');
           });

  
           showTotalasMoney(totalId,newTotal);
           showTotalPrice();
        }
        totalPriceVal = document.getElementById('totalPrice');
        totalPrice = 0;
        for (i=1;i<=nbrRows;i++) {
           priceStr = 'price'+i;
           totalStr = 'total'+i;
           priceVal = removeLeadingChar(document.getElementById(priceStr).innerHTML);
           totalVal = removeLeadingChar(document.getElementById(totalStr).innerHTML);
           totalPrice = totalPrice + parseFloat(totalVal);
           showTotalasMoney(priceStr,priceVal)
           showTotalasMoney(totalStr,totalVal);
           showTotalasMoney('totalPrice',totalPrice);
        }
      </script>
<?php
  fclose($fp);
?>
