#!/bin/sh
#takepic.sh
#this script is called by button.py, takes a picture, and deletes the old pictures in 
#the image directory, leaving the 10 newest pics, also emails primary user
#take picture and name it by the date and time it is taken
sudo raspistill -vf -w 640 -h 480 -o /var/www/images/doorbell/$(date "+%b_%d_%Y_%H_%M_%S").jpg
#change to image directory
cd /var/www/images/doorbell 
#select all images that arent the 10 newest images and remove them
sudo ls -t | sed -e '1,10d' | xargs -d '\n' rm
#email the primary user to alert him of someone at his door
sudo python /var/www/email_user.py
