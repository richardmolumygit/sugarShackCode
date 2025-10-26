<?php
  $targetFile = "links.csv";

  $myfile = fopen("leftnav.html", "w") or die("Unable to open file!");
  $lines = file($targetFile, FILE_IGNORE_NEW_LINES);	// he FILE_IGNORE_NEW_LINES flag ensures that no newline characters are appended at the end of each line
  $count = 0;
  $column = []; // create an array
  foreach($lines as $line) {
      $count += 1;
      list($href,$name) = explode(",",$line);
      if ($count > 1) {
        $txt = "<p><a href=\"".$href."\" target=\"rightnav\">".$name."</a></p>\n";         
        fwrite($myfile, $txt);
      }
  }
  fclose($myfile);
?>
<html>
  <body>
    <form action="index.html" method="post" enctype="multipart/form-data">
    <h2>Left navigatgion updated complete.<//h2></br>
    <input type="submit" name"Submit">
  </body>
</html>
