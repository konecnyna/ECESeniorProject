import bluetooth
from time import sleep
import sys
import time
def connect():
        #Open bluetooth socket on RFCOMM
        #sudo rfcomm connect /dev/rfcomm
        #sudo cat /dev/rfcomm0 gives
        
        timeout = time.time() + 2 #timeout 30secs
        
        socket = bluetooth.BluetoothSocket(bluetooth.RFCOMM)
        #socket.settimeout(2)
        try:
                socket.connect(('00:06:66:4E:DD:AE',1))
                #print "connected"
                socket.settimeout(None)
                return socket;
        except bluetooth.btcommon.BluetoothError as error:
                if(time.time()>timeout):
                    print "Code: 94"
                    exit()
                socket.close()
                #print error
                return -1;
        

def serial_read(socket):
        #print "Reading serial"
        reader = socket.makefile("rb")
        response = reader.readline()
        return response;



		

#get info from webpage.
#break if programm incorrectly called
if(len(sys.argv) != 2):
	exit();
args = str(sys.argv[1])


#print ("you passed: %s" % args)
	
#Loop until connection is made
socket = -1

while(socket < 0):
    socket = connect()

#print "starting"
#Loop inf and toggle led.
while(True):
        #print ("Sending: %s" %args)
        socket.send(args)
        try:
                res = serial_read(socket)
                print res
                break;
                        
              
        except bluetooth.btcommon.BluetoothError as error:
                print error
                socket.close()

        sleep(3)
        
socket.close()

