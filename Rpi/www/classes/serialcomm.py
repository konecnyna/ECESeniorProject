import bluetooth
from time import sleep
import sys
import time
#serialcomm.py
#this is used by serial.php to send commands via bluetooth to the avr

def connect():
        #Open bluetooth socket on RFCOMM
        #sudo rfcomm connect /dev/rfcomm
        #sudo cat /dev/rfcomm0 gives
        
        timeout = time.time() + 2 #timeout set to 2 secs
        socket = bluetooth.BluetoothSocket(bluetooth.RFCOMM)	#set up socket
        try:
                print "try"
                socket.connect(('00:06:66:4E:DD:AE',1))		#conect to rfcomm address of AVR bluetooth
                print "connected"
                socket.settimeout(None)
                return socket;
        except bluetooth.btcommon.BluetoothError as error:	#if it takes more than 2 secs, timeout
                if(time.time()>timeout):
                    print "Code: 94"
                    exit()
                socket.close()
                print error
                return -1;
        

def serial_read(socket):			#read from AVR
        #print "Reading serial"
        reader = socket.makefile("rb")		#write input to file
        response = reader.readline()		#readline from said file
        return response;



		

#get info from webpage.
#break if programm incorrectly called
if(len(sys.argv) != 2):
	exit();
args = str(sys.argv[1])		#sets command to second commandline arg


	
#Loop until connection is made
socket = -1

while(socket < 0):
    socket = connect()

#Loop inf and toggle led.
while(True):
        socket.send(args)			#send command
        try:
                res = serial_read(socket)	#read return value
                print res			#print return value for php to handle
                break;
                        
              
        except bluetooth.btcommon.BluetoothError as error:	#error checking
                print error
                socket.close()

        sleep(3)
        
socket.close()							#close socket

