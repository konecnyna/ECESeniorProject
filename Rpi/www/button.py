#!/usr/bin/env python

#button.py
#this file is turned into a background process that waits for the doorbell to be rung
import time
import RPi.GPIO as GPIO
import os

# tell the GPIO module that we want to use the 
# chip's pin numbering scheme
GPIO.setmode(GPIO.BCM)

# setup pin 23 as an input, and pull it high
GPIO.setup(23, GPIO.IN, pull_up_down=GPIO.PUD_UP)

while True:
	#this allows the pi to wait for a falling edge on the GPIO button pin
	#without having a CPU greedy loop. This is a software interrupt
	try:
		GPIO.wait_for_edge(23, GPIO.FALLING)	
		os.system("sudo ./var/www/take_pic.sh")		#this only happens after the falling edge
	except KeyboardInterrupt:  
		GPIO.cleanup()					#cleans up the GPIO pins if this 
								#script is ctrl C'ed
