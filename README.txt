Name: Thomas Cannon
Username: tcannon
Assignment: CPSC 462 Project
Date: April 25, 2014


## Description:

An implementation of the MeTube web application, which allows users to upload media files and interact with each other through comments, messages, and favorites. It also allows playlists to be created, and for users to subscribe to one another.

You can view the Technical Report for a more in-depth look into the project's development. This document is meant to help you deploy the application.


## Requirements:

* A LAMP stack
* Apache configured to allow the use of .htaccess files
* ffmpeg (to convert video and audio files)
* the libavcodec-extra-52 library for additional ffmpeg codecs
  * See: http://superuser.com/a/335839 for installation instructions
* The server should be able to serve flash files
* Vagrant *shouldn't* be necessary, but if you have trouble running the application in development I'd be more than happy to provide you with the Vagrant setup I used when developing the application. Please email me at tcannon@g.clemson.edu

## Enabling .htaccess files in Apache

Frameworks like CodeIgniter and Laravel require the use of .htaccess files to load the framework correctly. In order to enable .htaccess files, you need to change the “AllowOverride” option from “None” to “All” for  <Directory /var/www/> in /etc/apache2/sites-available/default, like so:

The file: /etc/apache2/sites-available/default

<Directory /var/www/>
                Options Indexes FollowSymLinks MultiViews
                AllowOverride All
                Order allow,deny
                allow from all
</Directory>


You will also need to enable the mod_rewrite module. The following stackoverflow answer shows how to enable it: http://stackoverflow.com/a/5758551

After the configuration has been changed, Apache will need to be restarted with the command: sudo /etc/init.d/apache2 restart

## Getting the application running

1. Copy the contents of the `www` directory into `spring14/u5` on the server. If the server path needs to be changed, you'll need to run a global find and replace for `spring14/u5` to replace it with the desired path
2. Make sure the correct group permissions and file/directory permissions have been set in `spring/u5`
  * `$ chgrp -R www-data ./`
  * `$ chmod -R g+rwx ./`
2. Create the Database
  1. Run the queries in `database_schema.sql` to create the "U5" database and its structure
  2. Make sure the application's database credentials are correct. They are located in `/www/app/config/database.php`, in the 'mysql' array
3. Make sure the directory `www/public/uploaded_media` exists. Otherwise, you won't be able to upload media to the application
