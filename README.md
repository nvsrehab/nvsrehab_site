nvsrehab_site
=============

Complete repository of NVSRehab Wordpress website including MySQL database 

Notes
=====
Here we backup the entire Wordpress folder `wordpress` (this is the directory `/public/wordpress_437746477` on the Earthlink webhost provider) and database backup `db` (.sql file exported from phpMyAdmin). 

For security we follow the recommendation here: 
http://wordpress.stackexchange.com/a/53014 

keeping the WordPress Local Environment DB credentials including:

 * database name, password and host for wordpress 
 * authentication unique keys and salts 

on the production server (currently Earthlink) in a separate file:

 * `/public/wordpress_437746477/production-config.php`

which is not copied to the github repository. For backup purposes an
encrypted version of this file is stored in the github repository at
the root of the Wordpress folder `wordpress/production-config.php`


Copy files from Repository to local server
==========================================
* clone the nvsrehab_site repository if a copy of it on the local
server does not already exist:
>git clone git@github.com:nvsrehab/nvsrehab_site.git

* if the repository already exists on the local server, pull the files
  from the repository:
>git pull

* then checkout the files:
>git checkout

Copy files from Repository to production server
===============================================

Submit files from local server to Repository
============================================

Backup files from production server to Repository
=================================================
