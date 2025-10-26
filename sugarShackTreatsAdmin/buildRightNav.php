<?php
  require "../common_functions.php";

  /* Blank td element */
  $blankTd = "blanktd.dat";
  $blankTdContents = file_get_contents($blankTd);

  /* Blank Tr element */
  $blankTrContents = "<tr colspan=\"2\">&nbsp;</tr>";

  /* Blank Td element */
  $blankSingleTdCells = "<td style=\"text-align: center;\">&nbsp;</td>";

  /* Blank Td element */
  $blankTdCells = "<tr colspan=\"2\">&nbsp;</tr>";

  /* Blank tr element */
  $blankTrHeadings = "        <tr>\n          TD1_HEAD1\n          TD2_HEAD1\n        </tr>\n        TR_BEGIN";
  
  /* Read templte for image <td> */
  $tdDetailsFileName = "detailsLine.dat";
 
  $tdContents = file_get_contents($tdDetailsFileName);
  $baseTdContents = $tdContents;

//echo "tdContents |".$tdContents."|\n";
    
  $tdHead = "<td style=\"text-align: center;\">TD_TEXT</td>";

//$linkSubmit = "<a href=\"javascript:changePages('1')\" class='image-button-container'>\nIMAGE_NAME";
    
  $divImageDetails1 = "DIV_DESCRIPTION1";
  $divImageDetails1 = "<div id='description1' class=\"overlay-text\">DIV_DESCRIPTION1</div>";
  $divImageDetails2 = "<div style=\"z-index:2;position:relative;\">DIV_DESCRIPTION2</div>";
//$tdImageDetails = "<img src=\"images/IMAGE_NAME\" alt=\"IMAGE_ALT\" width=\"200\" height=\"200\">";
//$tdImageDetails = "<img id='image1' src='images/IMAGE_NAME' alt='IMAGE_ALT' class='button-image' width='200' height='200'>";
  $tdImageDetails = "<a href=\"javascript:changePages('1')\" class='image-button-container'>\n<img id='image1' src='images/IMAGE_NAME' alt='IMAGE_ALT' class='button-image' width='200' height='200'>";
  
  $catalogFileName = "catalog.csv";
  $catalogFile = fopen($catalogFileName, "r") or die("Unable to open ".$catalogFileName." file!");

  $mainPageHeaderFile = "mainPageHeader.dat";
  $mainPageHeaderData = file_get_contents($mainPageHeaderFile);

  $mainPageFooterFileName = "mainPageFooter.dat";
  $mainPageFooterData = file_get_contents($mainPageFooterFileName);

  $mainPageOutputFileName = "mainPage.html";

  $tdCntr = 0;
  $lineNbr = 0;
  $readCntr = 0;
  $finalTr = 0;
  $itemNbr = 0;
  $conn = db_connect();
  if ($conn) {
     $selectActive = "SELECT * from catalog WHERE imageName IS NOT NULL AND TRIM(imageName) <> ''";
//   echo "<!--selectActive-".$selectActive."-->";
     $queryResult = $conn->query($selectActive);
     $numRows = $queryResult->num_rows;
//   echo "<!--numRows-".$numRows."-->\n";
     if ($numRows > 0) {
        while ($row = $queryResult->fetch_assoc()) {
           $itemNbr = $row['id'];
           $href = $row['imageName'];
           $name = $row['itemName'];
           $price = $row['price'];
           $description = $row['description'];
/*
           echo "href|".$href."|\n";
           echo "name|".$name."|\n";
           echo "price|".$price."|\n";
           echo "description|".$description."|\n";
*/        
           $readCntr += 1;
           $tdCntr += 1;
           
           if ($readCntr > 1) {
           
//            echo "|href |".$href."|||name |".$name."|||description |".$description."||\n";

//            $linkSubmit = "<a href=\"javascript:changePages('1')\" class='image-button-container'>\nIMAGE_NAME";
//            $tdImageDetails = "<img src=\"images/IMAGE_NAME\" alt=\"IMAGE_ALT\" width=\"200\" height=\"200\">"
//            $tdImageDetails = "<img id='image1' src='images/IMAGE_NAME' alt='IMAGE_ALT' class='button-image' width='200' height='200'>";

//            echo "|tdImageDetails |".$tdImageDetails."||\n";

//            find all occurances of 'search' in 'destination' with 'replacement'
//            str_replace('string to find','replacement','destination')
//            $linkReplace = str_replace("IMAGE_NAME",$linkSubmit,$tdImageDetails);
//            echo "|linkReplace |".$linkReplace."||\n";

              $tdReplace1 = str_replace("IMAGE_NAME",$href,$tdImageDetails);
              $tdReplace2 = str_replace("IMAGE_ALT",$name,$tdReplace1);
              $tdReplace3 = str_replace("1",$itemNbr,$tdReplace2);

//            echo "|tdReplace3 |".$tdReplace3."|\n";

//            $divImageDetails1 = "<div class=\"overlay-text\">>DIV_DESCRIPTION1</div>\n</a>";
              $divReplace = str_replace("DIV_DESCRIPTION1",$description,$divImageDetails1);
              $divReplace2 = str_replace("1",$itemNbr,$divReplace);

//            echo "|divReplace2 |".$divReplace2."|\n";
              
              $unitPrice = "unitPrice$itemNbr";
//            $tdReplace = str_replace("IMAGE_DESCRIPTION",$divReplace2,$tdReplace3);
              
//            echo "|tdReplace |".$tdReplace."|\n";
              
/*
              $firstTdItem = str_replace("1",$itemNbr,$tdContents);
              $newTdContents = str_replace("IMAGE_DETAILS",$tdReplace3,$firstTdItem);
*/
              $newTdContents = str_replace("IMAGE_DETAILS",$tdReplace3,$tdContents);
              $newContents1 = str_replace("IMAGE_DESCRIPTION",$divReplace2,$newTdContents);
              $newContents2  = str_replace("UNIT_PRICE_ID",$unitPrice,$newContents1);
              $newContents = str_replace("UNIT_PRICE_VALUE",$price,$newContents2);
              
//            echo "|newContents |".$newContents."||\n";

//            tdHead="<td style=\"text-align: center;\">TD_TEXT</td>";
              $tdHeadReplace = str_replace("TD_TEXT",$name, $tdHead);
//            echo "|tdHeadReplace |".$tdHeadReplace."|\n";
              
              $newTrLine = "";
              $lineNbr += 1;
//            echo "lineNbr (".$lineNbr.")\n";
              if ($lineNbr == 1) {
                 $lineInMainFile = explode("\n", $mainPageHeaderData);
                 $mainHeaderCntr = 0;
                 $saveHeaderCntr = 0;
                 foreach ($lineInMainFile as $line) {
                    $mainHeaderCntr += 1;
                    if (str_contains($line, "TD1_HEAD1")) {
                       $tdCntr += 1;
                       $tdHeadReplace = str_replace("TD1_HEAD1",$tdHeadReplace, $mainPageHeaderData);
//                     echo "tdHeadReplace |".$tdHeadReplace."|\n";
                       $mainPageHeaderData = $tdHeadReplace;		// Save changes to mainPageHeaderData
                    }
    
                    if (str_contains($line, "TR_BEGIN")) {
//                     echo "|newContents |".$newContents."|\n";
                       $newTrLine = "<tr>\n".$newContents."TD_BEGIN";
                       $trReplace = str_replace("TR_BEGIN",$newTrLine, $mainPageHeaderData);
//                     echo "|trReplace begin\n".$trReplace."\ntrReplace end\n";
                       $mainPageHeaderData = $trReplace;		// Save changes to mainPageHeaderData
                    } // if (str_containes($line,"TR_BEGIN"))
                 } // foreach ($lineInMainFile as $line)
                 $finalTr = 0;
              } else { // if ($lineNbr = 1)
//               echo "|href |".$href."|||name |".$name."|||description |".$description."||\n";
                 $lineNbr = 0;
                 $lineInMainFile = explode("\n", $mainPageHeaderData);
                 $mainHeaderCntr = 0;
                 $saveHeaderCntr = 0;
                 foreach ($lineInMainFile as $line) {
                    $mainHeaderCntr += 1;  
                    if (str_contains($line, "TD2_HEAD1")) {
                       $tdCntr += 1;
                       $tdHeadReplace = str_replace("TD2_HEAD1",$tdHeadReplace, $mainPageHeaderData);
//                     echo "tdHeadReplace |".$tdHeadReplace."|\n";
                       $mainPageHeaderData = $tdHeadReplace;		// Save changes to mainPageHeaderData
                       $saveHeaderCntr = $mainHeaderCntr;
                    }

                    if (str_contains($line, "TD_BEGIN")) {

//                     echo "|newContents |".$newContents."||\n";
                       
//                     $newTrLine = "<tr>\n".$newContents."        </tr>\n        TR_BEGIN";
                       $newTdLine = $newContents."        </tr>\n$blankTrHeadings";
                       $trReplace = str_replace("TD_BEGIN",$newTdLine, $mainPageHeaderData);

                       $trReplace2 = str_replace("TD_BEGIN",$newTrLine, $trReplace);
                       
//                     echo "|trReplace2 begin\n".$trReplace2."\ntrReplace2 end\n";
                       
                       $mainPageHeaderData = $trReplace2;		// Save changes to mainPageHeaderData

                    } // if (str_containes($line,"TR_BEGIN"))
                 } // foreach ($lineInMainFile as $line)
                 $finalTr = 1;
              } // if ($lineNbr = 1)
           } // if ($readCntr > 1)
        } // while ($row = $result-fetch_assoc())
     } // if ($queryResult->num_rows > 0)
  } // if ($conn)
/*
  if ($finalTr == 0) {
//   echo "<h1>Imcomplete tr</h1>\n";
     $mainPageHeaderData = str_replace("TD_BEGIN",$newTdLine, $mainPageHeaderData);
  }
*/
/*
  echo "Interium placehold - BEGIN\n";
  $lineInMainFile = explode("\n", $mainPageHeaderData);
  foreach ($lineInMainFile as $line) {
    echo $line;
  }
  echo "Interium placehold - END\n";
*/
//echo "Begin  processing\n";

  $lineInMainFile = explode("\n", $mainPageHeaderData);
  foreach ($lineInMainFile as $line) {
//    echo "BEFORE-line|".$line."|\n";
      if (str_contains($line, "TD_BEGIN")) {
         $tdReplace3 = str_replace("TD_BEGIN",$blankTdContents."        </tr>\n", $mainPageHeaderData);
//       echo "|tdReplace3 |".$tdReplace3."|\n";
         $mainPageHeaderData = $tdReplace3;

      } elseif (str_contains($line, "TR_BEGIN")) {
//         $trReplace = str_replace("TR_BEGIN",$blankTrContents, $mainPageHeaderData);
         $trReplace = str_replace("TR_BEGIN","<!--TR_EMPTY-->", $mainPageHeaderData);
//       echo "|trReplace |".$trReplace."|\n";
         $mainPageHeaderData = $trReplace;

      } elseif (str_contains($line, "TD1_HEAD1")) {
         $tdReplace1 = str_replace("TD1_HEAD1",$blankSingleTdCells."\n", $mainPageHeaderData);
//       echo "|tdReplace1 |".$tdReplace1."|\n";
         $mainPageHeaderData = $tdReplace1;
      } elseif (str_contains($line, "TD2_HEAD1")) {
         $tdReplace2 = str_replace("TD2_HEAD1",$blankSingleTdCells."\n", $mainPageHeaderData);
//       echo "|tdReplace2 |".$tdReplace2."|\n";
         $mainPageHeaderData = $tdReplace2;
      } // if (str_contains($line, "TD_BEGIN"))
  } // foreach ($lineInMainFile as $line)
//echo "End processing\n";
/*
  echo "BEGIN Header\n";
  $lineInMainFile = explode("\n", $mainPageHeaderData);
  foreach ($lineInMainFile as $line) {
    echo $line;
  } // foreach ($lineInMainFile as $line)
  echo "END Header\n";
  echo "BEGIN Footer\n";
  $lineInMainFile = explode("\n", $mainPageFooterData);
  foreach ($lineInMainFile as $line) {
    echo $line;
  } // foreach ($lineInMainFile as $line)
  echo "END Footer\n";
*/
  $bytesWritten = file_put_contents($mainPageOutputFileName, $mainPageHeaderData.$mainPageFooterData);
  fclose($catalogFile);
?>
<html>
  <body>
    <!--buildRightName.php-->
    <form action="index.html" method="post" enctype="multipart/form-data">
    <h2>Right navigatgion updated complete.<//h2></br>
    <input type="submit" name"Submit">
  </body>
</html>
