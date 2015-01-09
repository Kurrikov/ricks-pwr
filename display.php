<?php
#this file is for displaying the current and past status of the ups

$state = file_get_contents('state.txt');
echo "Current State: ".$state."<br>";

$capacity = file_get_contents('capacity.txt');
echo "Battery capacity: ".$capacity."%<br>";
##a bar showing the battery status would be nice

#setting colors for the battery bar
if(intval($capacity)>=75){
  $color = "#00FF00";
  }
elseif(intval($capacity)>=50){
  $color = "#FFFF00";
  }
elseif(intval($capacity)>=30){
  $color = "#FFA500";
  }
else{
  $color = "#FF0000";
  }
  

$lastEvent = file('lastEvent.txt');
for($i = count($lastEvent)-1; $i >= 0; --$i) {
  echo($lastEvent[$i]);
  echo("<br>");
  }


?>
