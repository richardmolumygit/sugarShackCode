<?php
  require "common_functions.php";
  $log_file = "clearCart.log";
  $fp = fopen($log_file,'w');

  $sessionId = session_id();
  echo "<!--sessionId-".$sessionId."-->\n";

  $conn = db_connect();

  $numRows = 0;
  if ($conn) {
     // INNER JOIN catalog with shopping cart
     $clearCart = "DELETE
               FROM shoppingCart
               WHERE cartid = '".$sessionId."'";
     echo "<!--clearCart-".$clearCart."-->\n";
     fwrite($fp,logTime()."sessionId-".$sessionId."-\n");
     fwrite($fp,logTime()."clearCart-".$clearCart."-\n");

     if ($conn->query($clearCart) === TRUE) {
        fwrite($fp,"-Success-\n");
     } else {
        fwrite($fp,"-Success-\n");
     } // if ($conn->query($clearCart) === TRUE)
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
     fwrite($fp,logTime()."numRows-".$numRows."-\n");
     echo "<!--numRows-".$numRows."-->\n";
  } // if $(conn)
?>
      <style>
       img {
         width: 40%; /* Sets the image width to 50% of its parent container */
         height: auto; /* Maintains aspect ratio */
       }
      </style>
      <!--script src="https://www.paypal.com/sdk/js?client-id=AWLq1jpoQe05jZZ2YCg7DKlNPfNJ8XM4Hx3m2TDRqYfkEIYvQjSBYMiDNk8jmlZKxg7EgdFamNLRbRLY&currency=USD&debug=true"></script-->
      <script src="https://www.paypal.com/sdk/js?client-id=AbUIXL6Uo6DiLdXoywaYmdM67Fh7Oj9rEGRq4rNmWl0qyXVhPtibC2yBsf5RHTuxJOW8Exxw2ydj0jWK&currency=USD&debug=true"></script>
      <script>
        window.location.href = "mainPage.php";
      </script>
