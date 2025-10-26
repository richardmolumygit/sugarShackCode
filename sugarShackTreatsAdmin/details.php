<?php
  require "../common_functions.php";
    
  fwrite($fp,logTime()."begin-POST-values\n");
  echo "<!--begin-POST-values-->\n";
  foreach ($_POST as $id=>$value) {
     fwrite($fp,logTime()."id<".$id.">value<".$value.">\n");
     echo "<!--id-".$id."-value-".$value."-><br>\n";
  }
  echo "<!--end-POST-values-->\n";
  echo "<!--begin-GET-values-->\n";
  foreach ($_GET as $id=>$value) {
     fwrite($fp,logTime()."id<".$id.">value<".$value.">\n");
     echo "<!--id-".$id."-value-".$value."-><br>\n";
  }
  echo "<!--end-GET-values-->\n";
  unset($itemName);
  unset($itemDesc);
  unset($unitPrice);
  unset($itemNbr);
  unset($postId);
//unset($username);

  if (isset($_POST['itemName'])) {
     $itemName = $_POST['itemName'];
  } else if (isset($_GET['itemName'])) {
     $itemName = $_GET['itemName'];
  }
  if (isset($_POST['itemDesc'])) {
     $itemDesc = $_POST['itemDesc'];
  } else if (isset($_GET['itemDesc'])) {
     $itemDesc = $_GET['itemDesc'];
  }
  if (isset($_POST['itemImage'])) {
     $itemImage = $_POST['itemImage'];
  } else if (isset($_GET['itemImage'])) {
     $itemImage = $_GET['itemImage'];
  }

  if (isset($_POST['itemDesc'])) {
     $itemDesc = $_POST['itemDesc'];
  } else if (isset($_GET['itemDesc'])) {
     $itemDesc = $_GET['itemDesc'];
  }

  if (isset($_POST['unitPrice'])) {
     $unitPrice = $_POST['unitPrice'];
  } else if (isset($_GET['unitPrice'])) {
     $unitPrice = $_GET['unitPrice'];
  }

  if (isset($_POST['itemNbr'])) {
     $itemNbr = $_POST['itemNbr'];
  } else if (isset($_GET['itemNbr'])) {
     $itemNbr = $_GET['itemNbr'];
  }
  
  if (isset($_POST['postId'])) {
     $postId = $_POST['postId'];
  } else if (isset($_GET['postId'])) {
     $postId = $_GET['postId'];
  }
  
  echo "<!--itemName-".$itemName."--><br>\n";
  echo "<!--itemDesc-".$itemDesc."--><br>\n";
  echo "<!--itemNbr-".$itemNbr."--><br>\n";
  echo "<!--unitPrice-".$unitPrice."--><br>\n";
  if (isset($postId)) {
     echo "<!--postId-".$postId."--><br>\n";
     header("Location:addToCart.php?postId=".$postId);
  }
  
/*
      <script src="js/itemDetails.js"></script>
*/
?>
      <style>
       div {
         display:inline-block;
       }
      </style>
      <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputField = document.getElementById('qtyInput'); // Replace with your input's ID
            const qtyCheck = document.getElementById('qtyCheck'); // Replace with your checkbox's ID

            inputField.addEventListener('focus', function() {
                if (qtyCheck.checked) {
                    qtyCheck.checked = false;
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const inputField = document.getElementById('qtyInput'); // Replace with your input's ID
            const qtyCheck = document.getElementById('qtyCheck'); // Replace with your checkbox's ID


            qtyCheck.addEventListener('change', function() {
                if (qtyCheck.checked) {
                    qtyInput.value = ''; // Set input value to empty string
                }
            });
        });

      </script>
      <table border=1>
        <form id='addToCart' action="details.php" method="post" target="_blank">
          <tr>
            <td colspan="5" style="text-align: center;"><h2>Sugar Shack Treats</h2></td>
          </tr>
          <tr>
            <td width=1%>&nbsp;</td>
<?php
            echo"            <td width='40%' style='text-align: center;'><img id='itemImage' src='".$itemImage."'></td>\n";
?>
<?php
              echo "            <td width='20%' style='text-align: center;'>\n";
              echo "              <div><p name='itemName'>".$itemName."</p></div>\n";
              echo "              <div>$</div>\n";
              echo "              <div><p name='unitPrice'>".$unitPrice."</p></div>\n";
              echo "              <textarea id='itemDesc' name='itemDesc' rows='5' cols='46' style='border-width:0px; border:none; resize: none;'>".$itemDesc."</textarea>\n";
?>
              <p>
                  <input type="image" src="images/addToCart_large.png" border="0" name="submit" title="Add to Cart" alt="Add to Cart" />
<?php
                  echo"                  <input type='hidden' name='itemNbr' value='".$itemNbr."'>\n";
                  echo"                  <input type='hidden' name='postId' value='".$itemNbr."'>\n";
?>
              </p>
            </td>
            <td width='20%'>
              <input type=number id='qtyInput' name='qty' style='width: 40px' onfocus='unselect()'><label for qty>Quantity</label></br>
              <input type='radio' id='qty2' name='qtyCheck' onclick='zeroQty()'><label for qty2>1 dozen</label></br>
              <input type='radio' id='qty3' name='qtyCheck' onclick='zeroQty()'><label for qty3>2 dozen</label></br>
              <input type='radio' id='qty4' name='qtyCheck' onclick='zeroQty()'><label for qty4>3 dozen</label></br>
            </td>
            <td width='1%'>&nbsp;</td>
          </tr>
          <tr><td colspan='6'>&nbsp;</td></tr>
          <tr>
            <td colspan="5" style="text-align: center;">Email us for questions at: <a href="mailto:SugarShackTreats@gmail.com">SugarShackTreats@gmail.com</a></td>
          </tr>
          <!--tr>
            <td colspan="5" style="text-align: center;"><img id='finalLogo' src="images/finalLogoSept2025.jpg"></td>
          </tr-->
        </form>
      </table>
