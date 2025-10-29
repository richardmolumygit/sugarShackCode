<?php
$target_dir = ".";
$targetFile = "links.csv";
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));

//echo "targetFile [" . $targetFile . "]";
//echo "</br>";
// Check if image file is a actual image or fake image
/*
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}
*/

// Check if file already exists
/*
if (file_exists($targetFile)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}
*/

// Check file size
/*
if ($_FILES["fileToUpload"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}
*/
// Allow certain file formats
//if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
//  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
//  $uploadOk = 0;
//}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
/*
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
*/
  $myfile = fopen("C:\Users\Rich\Documents\sugarshacktreats\leftnav.html", "w") or die("Unable to open file!");
  $lines = file($targetFile, FILE_IGNORE_NEW_LINES);	// he FILE_IGNORE_NEW_LINES flag ensures that no newline characters are appended at the end of each line
  $count = 0;
  $column = []; // create an array
  foreach($lines as $line) {
      $count += 1;
//     echo "<br/>" . $count . "[".  $line . "]";
      list($href,$name) = explode(",",$line);
//    echo "<br/>name [".$name."] description [".$description."] uom [".$uom."] price [".$price."]";
      if ($count > 1) {
        $txt = "<p><a href=\"".$href."\" target=\"rightnav\">".$name."</a></p>\n";         
//      echo "<p><a href=\"".$href."\" target=\"rightnav\">".$name."</a></p>";
        fwrite($myfile, $txt);
      }
  }
  fclose($myfile);
/*
  $myfile = fopen("C:\Users\Rich\Documents\sugarshacktreats\leftnav.html", "w") or die("Unable to open file!");
  $txt = "John Doe\n";
  fwrite($myfile, $txt);
  $txt = "Jane Doe\n";
  fwrite($myfile, $txt);
*/
}
?>