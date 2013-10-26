import bluetooth
from time import sleep
import sys
def connect():
        #Open bluetooth socket on RFCOMM
        #sudo rfcomm connect /dev/rfcomm
        #sudo cat /dev/rfcomm0 gives
        try:
                socket = bluetooth.BluetoothSocket(bluetooth.RFCOMM)
                socket.connect(('00:06:66:4E:DD:AE',1))
                print "connected"
                return socket;
        except bluetooth.btcommon.BluetoothError as error:
                socket.close()
                print error
                return -1;
        

def serial_read(socket):
        print "Reading serial"
        reader = socket.makefile("rb")
        response = reader.readline()
        return response;



		

#get info from webpage.		
#if(len(sys.argv) != 1):
#	exit();
args = str(sys.argv[1])


print ("you passed: %s" % args)
'''	
#Loop until connection is made
socket = -1
while(socket < 0):
        socket = connect()

print "starting"
success = True
#Loop inf and toggle led.
while(True):
        socket.send(args)
        try:
                res = serial_read(socket)
                print res
                if not "success" in res:
                        print "error"
                        break;
              
        except bluetooth.btcommon.BluetoothError as error:
                print error
                socket.close()

        sleep(3)
        
socket.close()
'''
