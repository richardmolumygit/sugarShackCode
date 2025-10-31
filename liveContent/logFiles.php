<?php
  function zeroFill($inStr) {
    $returnVal = $inStr;
    if (strlen($inStr) == 1) { $returnVal = "0".$inStr; }
    return($returnVal);
  }
  function logTime() {
    $today = getdate();
    $month = zeroFill($today['mon']);
    $day = zeroFill($today['mday']);
    $hours = zeroFill($today['hours']);
    $minutes = zeroFill($today['minutes']);
    $seconds = zeroFill($today['seconds']);
    $out = ""
    . $month . "-"
    . $day . "-"
    . $today['year'] . " "
    . $hours . ":"
    . $minutes . ":"
    . $seconds . ">";
    return ($out);
  }
/*
  $httpHost = $_SERVER['HTTP_HOST'];
  $docRoot = $_SERVER['DOCUMENT_ROOT'];
  $fileName = $_SERVER["SCRIPT_FILENAME"];
  $scriptName = $_SERVER["SCRIPT_NAME"];
  $curpage = $_SERVER['PHP_SELF'];
  $seperator = $scriptName[0];
  $secondPos = strrpos($scriptName,$seperator);
  $pathToPage = $docRoot.substr($scriptName,0,$secondPos).$seperator;
  $siteUrl = "http://".$httpHost.substr($scriptName,0,$secondPos).$seperator;

  if ($secondPos > 0) {
     //$log_file = str_replace(".php",".txt",($docRoot.substr($scriptName,0,$secondPos).$seperator."logs".$seperator.substr($scriptName,$secondPos+1)));
     $log_file = str_replace(".php",".txt",($docRoot.substr($scriptName,0,$secondPos).$seperator.substr($scriptName,$secondPos+1)));
     $log_file = str_replace(".php",".txt",($pathToPage.substr($scriptName,$secondPos+1)));
  }
*/
  $curpage="";
  $log_file = "test.log";
  $fp = fopen($log_file,'w');
  fwrite($fp,logTime()."-start-$curpage-\n");
?>
