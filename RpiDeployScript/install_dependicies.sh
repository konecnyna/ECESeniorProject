#! /bin/sh

#Update apt-get
sudo apt-get update

#Install packages needed for senior project
sudo apt-get --ignore-missing install -y mysql-server apache2 php5 libapache2-mod-php5 php5-cgi bluez-utils

#This isn't done and needs to be tested.


