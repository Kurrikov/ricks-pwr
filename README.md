This is a utility that makes the status of an uninterrupted power supply available remotely.
A Python scrips is used to get the data and upload it to the server. PHP is then used by the server to store and display this data.


The CSV file is used to store the past states of the UPS.
Format: status,capacity,last_event, time
For example: Normal,100,"Blackout at 2014/07/11 01:39:42",2015-09-21 15:31:16
