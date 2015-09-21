<?php
// this file is for displaying the current and past status of the ups

/**
 * The CSV file is used to store the past states of the UPS.
 * Format: status,capacity,last_event, time
 * For example: Normal,100,"Blackout at 2014/07/11 01:39:42",2015-09-21 15:31:16
 */

$csv_data = file_get_contents('status.log');
$lines = explode("\n", $csv_data); #array of all lines in log file
$mostRecent = str_getcsv($lines[0]); #the most recent status of the UPS
$currentStatus = $mostRecent[0];
$currentCapacity = $mostRecent[1];
$lastEvent = $mostRecent[2];
$time = $mostRecent[3];

// setting colors for the battery bar
if(intval($currentCapacity)>=75){
  $color = "#00FF00";
  }
elseif(intval($currentCapacity)>=50){
  $color = "#FFFF00";
  }
elseif(intval($currentCapacity)>=30){
  $color = "#FFA500";
  }
else{
  $color = "#FF0000";
  }

// display webpage
echo "<!DOCTYPE html>
<html>
<head>
  <style>
  th{
    text-align: center;
    }
  td{
    background-color: $color;
    width: 100px;
    height:30px;
    margin:20px;
    }
  </style>
</head>

<body>";

echo "<table>
  <tr>";

// display a battery bar made of table cells
for($i=0; $i<ceil($currentCapacity/10); ++$i) {
  echo "<td></td>";
  }

echo "</tr>
</table>
<br>";

echo "Battery capacity: $currentCapacity% <br>\n";
echo "Current State: $currentStatus<br>\n";
echo "Last updated: $time<br>\n";
echo "Last power event: $lastEvent";

echo "
</body>
</html>";
?>
