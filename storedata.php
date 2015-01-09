<?php
#this file receives the incoming data and stores it

#make variables out of the incomming data
$state = $_POST['state'];
$capacity = $_POST['capacity'];
$lastEvent = $_POST['lastEvent'];

#echo $_POST['state'];
#echo $_POST['capacity'];
#echo $_POST['lastEvent'];

//store data on disk
file_put_contents('state.txt', $state);
file_put_contents('capacity.txt', $capacity);

$prevEvents = file_get_contents('lastEvent.txt');
$prevEvents .= "\n".$lastEvent;
file_put_contents('lastEvent.txt', $prevEvents);

#TODO: remove old entries after n entries
#TODO: if state goes from 'Power Failure' to 'Normal' add an entry to the log saying that power has been restored




?>
