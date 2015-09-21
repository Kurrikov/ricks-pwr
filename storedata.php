<?php
#this file receives the incoming data and stores it
ini_set('display_errors', 1);

#make variables out of the incomming data
$state = $_POST['state'];
$capacity = $_POST['capacity'];
$lastEvent = $_POST['lastEvent'];
$time = $_POST['time'];

# echos for debugging
#echo $_POST['state'];
#echo $_POST['capacity'];
#echo $_POST['lastEvent'];

# $data = array($state, $capacity, $lastEvent);

/**
 * The CSV file is used to store the past states of the UPS.
 * Format: status,capacity,last_event, time
 * For example: Normal,100,"Blackout at 2014/07/11 01:39:42",2015-09-21 15:31:16
 */

# store data on disk ***OLD***
file_put_contents('state.txt', $state);
file_put_contents('capacity.txt', $capacity);

#store data on disk as a csv
$file = fopen('status.log',"a+");
fputcsv($file, array($state, $capacity,$lastEvent));
fclose($file);

$prevEvents = file_get_contents('lastEvent.txt');
$prevEvents .= "\n".$lastEvent;
file_put_contents('lastEvent.txt', $prevEvents);

#TODO: remove old entries after n entries
#TODO: if state goes from 'Power Failure' to 'Normal' add an entry to the log saying that power has been restored


?>
