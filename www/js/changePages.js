        function addToCartPopup(item) {
          text = "Nope";
          if (confirm("Add "+item+" to cart ?")) {
             text="Added "+item+" to cart";
          }
          document.getElementById('formId').submit();
        }
        function changePages(itemNbr) {

          item = document.getElementById('image'+itemNbr).alt;
          itemDesc = document.getElementById('description'+itemNbr).innerHTML;
          imageSrc = document.getElementById('image'+itemNbr).src;
          unitPrice = document.getElementById('unitPrice'+itemNbr).value;
//          buttonId = document.getElementById('buttonId'+itemNbr).value;
//          alert('item |' + item + '| itemDesc |' + itemDesc + '| imageSrc |' + imageSrc + '|');
//          location.replace('details.php?itemName='  + item + '?payPalButtonId=' + buttonId + '?itemDesc=' + itemDesc + '?itemImage=' + imageSrc + '?unitPrice=' + unitPrice);
          location.replace('details.php?itemNbr=' + itemNbr + '&itemName='  + item + '&itemDesc=' + itemDesc + '&itemImage=' + imageSrc + '&unitPrice=' + unitPrice);
        }
