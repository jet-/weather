# weather
My Weather station


My Weather station, running on LAMP stack.
Getting data from Raspberry Pi (has temperature/humidity sensor), connetected to my Wifi at home.
Pi accesses/mounts a NFS share on my server and sends data (cronjob).
My server imports the data from weather station into MariaDB/MySQL table (cronjob) and Apache servers it to the browser.

1. You have to create Database in MySQL/MariaDB server

2. Create tables

	mysql -p  weather < mysql.sql

3. Create user in MySQL/MariaDB and grant access for the database

4. Change the conf.php file accordingly

5. Copy all the files from the project to your web server 

	git clone https://github.com/jet-/weather.git

6. Point the browser to https://server/weather/weather.php

#
![entry](https://github.com/jet-/weather/blob/main/images/screen.png)

![entry](https://github.com/jet-/weather/blob/main/images/rpi.png)

#

Buy me a coffee - BTC: 1L25rmhgM9yvJYcUsUkNJf49EfFjQYmCbt
