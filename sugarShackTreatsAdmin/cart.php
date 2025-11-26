<?php
  require "../common_functions.php";

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
      <script>
        window.onload = function() {
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
        const formatterUSD = new Intl.NumberFormat('en-US', {
          style: 'currency',
          currency: 'USD'
        });
        function removeLeadingChar(input) {
          return input.substring(1,input.length);
        }
        function showTotalPrice() {
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
           priceId = 'price'+lineNbr;
           qtyInput = 'qtyInput'+lineNbr;
           totalId = 'total'+lineNbr;
           var mySelect = document.getElementById(qtyInput).value;
           var priceStr = document.getElementById(priceId).innerHTML;
           // chop off first character of the string (The $)
           priceAmt = removeLeadingChar(document.getElementById(priceId).innerHTML);
	   newTotal = priceAmt * mySelect;
           showTotalasMoney(totalId,newTotal);
           showTotalPrice();
        }

        function showTotalasMoney(totalId,newTotal) {
          document.getElementById(totalId).innerHTML = formatterUSD.format(newTotal);
        }
      </script>
      <table>
        <tr>
          <td colspan="4" style="text-align: center;"><h2>Sugar Shack Treats</h2></td>
        </tr>
<?php
  $displayId=0;
  if ($numRows > 0) {
?>
        <tr>
          <td style='text-align: left'>Item</td>
          <td style='text-align: left'>Quanity</td>
          <td style='text-align: left'>Price</td>
          <td style='text-align: right'>Total</td>
        </tr>
<?php
        while ($row = $queryResult->fetch_assoc()) {
//         print_r($row);
           $catId = $row['id'];
           $imageName = $row['imageName'];
           $itemName = $row['itemName'];
           $price = floatval($row['price']);
           $description = $row['description'];
           $quantity = $row['quantity'];
           $cartId = $row['cartId'];
/*
echo "<!--price-".$price."-quantity-|".$quantity."|-->\n";
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
          <td style='text-align: left'><?php echo $itemName; ?></td>
          <td style='text-align: left; vertical-align: top'>
            <select id='qtyInput<?php echo $displayId; ?>' name='qtyInput<?php echo $displayId; ?>' onChange="changeTotal('<?php echo $displayId;?>')">
<?php
//echo "<!--quantity-".$quantity."-->\n";
              $qty=0;
              for($qty=1;$qty<=15;$qty++) {
//echo "<!--qty-".$qty."-->\n";
                $out = $qty;
                if ($qty == 13) { $out = "1 dozen"; }
                if ($qty == 14) { $out = "2 dozen"; }
                if ($qty == 15) { $out = "1 dozen"; }
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
        } // ($row = $queryResult->fetch_assoc())
?>
        <tr>
          <td colspan="3" style='text-align: right'>Total</td>
          <td id='totalPrice' name='totalPrice' style='text-align: right></td>
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
          <td colspan="4" style='text-align: center'>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" style="text-align: center;">Email us for questions at: <a href="mailto:SugarShackTreats@gmail.com">SugarShackTreats@gmail.com</a></td>
        </tr>
        <tr>
          <td colspan="4" style="text-align: center;"><img id='finalLogo' src="images/finalLogoSept2025.jpg"></td>
        </tr>
      </table>
