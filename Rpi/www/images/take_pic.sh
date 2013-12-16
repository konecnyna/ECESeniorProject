#!/bin/sh
sudo raspistill -o /var/www/images/doorbell/$(date "+%b_%d_%Y_%H_%M_%S").jpg
cd /var/www/images/doorbell 
sudo ls -t | sed -e '1,10d' | xargs -d '\n' rm

