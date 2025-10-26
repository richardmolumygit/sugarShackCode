        window.onload = function() {
          var link = window.location.href;
          encoded = encodeURIComponent(link);
          decoded = decodeURIComponent(encoded);
          parameters = decoded.split("?");
          paramLth = parameters.length;
          var itemName = 'Item Huh?';
          var itemDesc = 'Desc Huh?';
          var itemImage = 'Image Huh?';
          var unitPrice = 'unit Price?';
          var payPalButtonId = 'payPalButtonId?';
          for (i=0; i < paramLth; i++) {
             item = parameters[i];
             if (item.includes("=")) {
             detailsArray = item.split('=');
             details0 = decodeURI(detailsArray[0]);
             details1 = decodeURI(detailsArray[1]);

             if (details0 == 'itemName') { itemName = details1; }
             if (details0 == 'itemDesc') { itemDesc = details1; }
             if (details0 == 'itemImage') { itemImage = details1; }
             if (details0 == 'unitPrice') { unitPrice = details1; }
             if (details0 == 'payPalButtonId') { payPalButtonId = details1; }
             }
          }
          outPrice = '$' + unitPrice;
          outName = itemName + outPrice
          document.getElementById('itemName').textContent = itemName;
//        document.getElementById('itemName').textContent = outName;
          document.getElementById('itemDesc').textContent = itemDesc;
          document.getElementById('itemImage').src = itemImage;
          document.getElementById('unitPrice').value = outPrice;

          document.getElementById('nameOfItem').textContent = itemName;
          document.getElementById('priceOfItem').textContent = unitPrice;
        }
