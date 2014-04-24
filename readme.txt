Name: Thomas Cannon
Username: tcannon
Assignment: CPSC 462 Project
Date: April 22, 2014


## Description:

The implementation of the MeTube web application, which allows the user to upload media files and interact with each other through comments, messages, and favorites. It also allows playlists to be created, and for users to subscribe to one another.

**Note:** I did not have any other team members (my team member dropped over spring break), hence why there is no Team Evaluation in my submission!

## Implementation details:

This version of MeTube is implemented with a modified version of the Laravel Framework (http://laravel.com/). The modifications were necessary to make the site work on the mmlab servers.

The application uses MediaElement.js to provide a flash fallback for audio/video files (http://mediaelementjs.com/). Your server should be able to serve flash assets.

Note that the application is currently "hard coded" to exist in `/spring14/u5/` on the server. You can change the site to work in another location by finding/replacing all instances of this string.

The application originally used the package manager "Composer" (https://getcomposer.org/) to manage the packages required for the site. However, for the interest of making the site easier to grade and test, the package files have been "vendorized" (stored in the vendor/ directory). If the site is acting up however, you can follow the instructions for installing Composer and running `composer install` to install the missing packages.

The CSS is custom-written, so there are no dependencies there.

Additionally, I used Vagrant to spool up a headless VM to run the application in an isolated environment. This was to make sure the development environment matched the mmlab server as closely as possible. If you have any issues running the project, I'd be more than happy to give you access to the full Github Repo (which includes the code necessary for Vagrant to work). You can learn more about Vagrant here: http://www.vagrantup.com/

## Requirements:

* Apache configured to allow the use of .htaccess files
* ffmpeg (to convert video and audio files)
* The server should be able to serve flash files
* Vagrant *shouldn't* be necessary, but if you have trouble running the application in development I'd be more than happy to provide you with my Vagrant setup.

## Getting the application running

There are a few steps to getting the application up and runnning:

1. Copy the contents of the `www` directory into `spring14/u5` on the server. If the server path needs to be changes, you'll need to run a global find/replace for `spring14/u5` and replace it with the correct path
2. Create the databse.
  1. The first thing you'll want to do is make sure the application's database credentials are correct. They are located in `/www/app/config/database.php`, in the 'mysql' array.
  2. Then either migrate the database (recommended), or load from the SQL dump.
    * Running migrations is as simple as running `php artisan migrate` from the `www` directory (or `php www/artisan` if you're at this directory). This will automatically create the database based on the migration files in `www/app/database/migrations`.
    * If the migration tool doesn't work, you can manually load in the table schema using the `backup_schema.sql` file provided.
3. Make sure the directory `www/public/uploaded_media` exists. Otherwise, you won't be able to upload media from the application.

You then should be able to launch the application by going to the correct path. If anything goes wrong, please email me at tcannon@clemson.edu so I can help resolve the issue. :)

## Enabling .htaccess files in Apache

Frameworks like CodeIgniter and Laravel require the use of .htaccess files to load the framework correctly. In order to enable .htaccess files, you need to change the “AllowOverride” option from “None” to “All” for  <Directory /var/www/> in /etc/apache2/sites-available/default, like so:

The file: /etc/apache2/sites-available/default

<Directory /var/www/>
                Options Indexes FollowSymLinks MultiViews
                AllowOverride All
                Order allow,deny
                allow from all
</Directory>


You will also need to enable the mod_rewrite module. The following stackoverlow expanle shows how to enable it: http://stackoverflow.com/a/5758551

After the configuration has been changed, Apache will need to be restarted with the command: sudo /etc/init.d/apache2 restart
