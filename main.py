# This is the main python file
# It grabs data from the UPS, formats it, and uploads it to the server

import time
import urllib2, urllib
import subprocess
import re

def main():
  #timing loop that checks the status and sends it to the server every so often (10 minutes or so)
  # uncomment for production
  """
  while True:
    getStatus()
    send()
    #wait ten minutes
    time.sleep(600) #time to sleep in seconds
  """

  #for testing
  send()

def send():
  #array of tuples in the form (variable, data)

  #for live use, get status from UPS
  mydata = getStatus()

  mydata=urllib.urlencode(mydata)
  path='http://example-website.com/storedata.php' #the url you want to POST to
  req=urllib2.Request(path, mydata)
  req.add_header("Content-type", "application/x-www-form-urlencoded")
  page=urllib2.urlopen(req).read()

  #print any echos from the php page
  #print page

def getStatus():
  #get the current status of the ups
  stat = subprocess.check_output(["pwrstat", "-status"])

  #output should be in this form:
  """
  Properties:
    Model Name................... CP 1500C
    Firmware Number.............. BFE5107.B23
    Rating Voltage............... 120 V
    Rating Power................. 900 Watt

  Current UPS status:
    State........................ Power Failure
    Power Supply by.............. Battery Power
    Utility Voltage.............. 0 V
    Output Voltage............... 120 V
    Battery Capacity............. 100 %
    Remaining Runtime............ 38 min.
    Load......................... 153 Watt(17 %)
    Line Interaction............. None
    Test Result.................. Unknown
    Last Power Event............. Blackout at 2014/07/11 01:39:42
  """


  #TODO use regex to get values for status
  #get the current state of the UPS (Normal or Power Failure)
  if("Normal" in stat):
    state = "Normal"
  elif("Power Failure" in stat):
    state = "Power Failure"

  #get the current battery capacity
  s2 = "Battery Capacity............. "
  #get three characters after s2
  s3 = stat[stat.index(s2) + len(s2):stat.index(s2) + len(s2)+3]

  #check if the last character is a digit
  #(it won't be for all battery capacities below 100 %)
  if(not str.isdigit(s3[-1])):
    #remove the last character
    s3 = s3[0:2]

  #check if the next last character is a digit
  if(not str.isdigit(s3[-1])):
    #remove the last character
    s3 = s3[0]

  #convert battery capacity to a storable integer
  capacity = int(s3)

  #get the last power event
  s2 = "Last Power Event............. "
  #everything after s2
  lastEvent = stat[s1.index(s2) + len(s2):]

  #put status values into array
  status = [('state',state),('capacity',capacity),('lastEvent',lastEvent),('time',strftime("%Y-%m-%d %H:%M:%S"))]
  #return array
  return status

if __name__ == '__main__':
  main()
