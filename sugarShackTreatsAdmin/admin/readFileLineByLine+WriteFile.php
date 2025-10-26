<?php
$sourceFile = 'input.txt';
$destinationFile = 'output.txt';

// Read the entire file into a string
$fileContent = file_get_contents($sourceFile);

if ($fileContent === false) {
    die("Error: Could not read the source file.");
}

// Split the string into an array of lines
$lines = explode("\n", $fileContent);

// Open the destination file for writing
$outputHandle = fopen($destinationFile, 'w');

if ($outputHandle === false) {
    die("Error: Could not open the destination file for writing.");
}

// Iterate through the lines and write to the destination file
foreach ($lines as $line) {
    // Optionally, you can perform operations on each line here before writing
    fwrite($outputHandle, $line . "\n");
}

// Close the destination file
fclose($outputHandle);

echo "File successfully processed and written to $destinationFile.";
?>