<?php
  require "common_functions.php";

  $sessionId = session_id();
  echo "<!--sessionId-".$sessionId."-->\n";

  $conn = db_connect();

  $numRows = 0;
  if ($conn) {
     // INNER JOIN catalog with shopping cart
     $query = "SELECT 
               c.id, c.imageName, c.itemName, c.price, c.description, 
               s.quantity, s.cartId 
               FROM catalog c 
               INNER JOIN shoppingCart s 
               ON c.id = s.itemNbr
               WHERE s.cartid = '".$sessionId."'";
     echo "<!--query-".$query."-->\n";

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
        var cartItemsArray = [];
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
           echo "             { name: '".$itemName."', quantity: ".$quantity;
           echo ", unit_amount: ".$price." }";
           if ($rowNbr < $numRows) {
              echo ",";
           }
           echo "\n";
        } // while ($row = $queryResult->fetch_assoc())
//          { name: "T-shirt", quantity: 2, unit_amount: 20.00 },
//          { name: "Jeans", quantity: 1, unit_amount: 45.00 }
?>
          ];
        window.onload = function() {
          showTotalPrice();
        }
/*
        console.info('-----------------------------------');
        cartItemsArray.forEach(cItem => {
          cName = cItem.name;
          console.info('initial-cName |'+cName+'|');
        });
*/
        const formatterUSD = new Intl.NumberFormat('en-US', {
          style: 'currency',
          currency: 'USD'
        });
      </script>
      <table border=1>
        <tr>
          <td colspan="4" style="text-align: center;"><h2>Sugar Shack Treats</h2></td>
        </tr>
<?php
  $displayId=0;
  if ($numRows > 0) {
?>
        <tr>
          <td style='text-align: left'>Item</td>
          <td style='text-align: left'>Quantity</td>
          <td style='text-align: left'>Price</td>
          <td style='text-align: left'>Total</td>
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
        <tr>
          <td id='cartItemName<?php echo $displayId; ?>' style='text-align: left'><?php echo $itemName; ?></td>
          <td style='text-align: left; vertical-align: top'>
            <select id='qtyInput<?php echo $displayId; ?>' name='qtyInput<?php echo $displayId; ?>' onChange="changeTotal('<?php echo $displayId;?>')">
<?php
//echo "<!--quantity-".$quantity."-->\n";
              $qty=0;
              for($qty=1;$qty<15;$qty++) {
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
          <td style='text-align: left' id='price<?php echo $displayId ?>' name='price<?php echo $displayId ?>'>$<?php echo $price; ?></td>
          <td style='text-align: right' id='total<?php echo $displayId ?>' name='total<?php echo $displayId ?>'>$<?php echo $total; ?></td>
        </tr>
<?php
           } // if ($cartId = $sessionId)
        } // ($row = $queryResult1->fetch_assoc())
?>
        <tr>
          <td colspan="2" style='text-align: right'>&nbsp;</td>
          <td style='text-align: left'>Total</td>
          <td id='totalPrice' name='totalPrice' style='text-align: right'>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" style='text-align: center'>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" style='text-align: center'><div id="paypal-button-container"></div></td>
        </tr>
<?php
  } else {
?>
        <tr>
          <td colspan="4" style='text-align: center'><h2>Your cart is empty</h2></td>
        </tr>
<?php
  }
?>
        <tr>
          <td colspan="4" style="text-align: center;">Email us for questions at: <a href="mailto:SugarShackTreats@gmail.com">SugarShackTreats@gmail.com</a></td>
        </tr>
        <tr>
          <td colspan="4" style='text-align: center'>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" style="text-align: center;"><img id='finalLogo' src="images/finalLogoSept2025.jpg"></td>
        </tr>
      </table>
      <script>
  
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

        function showTotalasMoney(totalId,newTotal) {
          document.getElementById(totalId).innerHTML = formatterUSD.format(newTotal);
        }
        function removeLeadingChar(input) {
          return input.substring(1,input.length);
        }
        function showTotalPrice() {
//alert('showTotalPrice');
          totalPriceVal = document.getElementById('totalPrice');
          nbrRows = '<?php echo $numRows; ?>';
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
        nbrRows = '<?php echo $numRows; ?>';
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
