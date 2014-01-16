nvsrehab_site
=============

Complete repository of NVSRehab Wordpress website including MySQL database 

Notes
=====

Here we backup the entire Wordpress folder `wordpress` (this is the
directory `/public/wordpress_437746477` on the Earthlink webhost
provider) and database backup `db` (.sql file exported from phpMyAdmin). 

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

Workflow
========

There are three repositories we refer to in this document are: 
 * original repository nvsrehab/nvsrehab_site
 * forked repository: 'your-account'/nvsrehab_site
 * repository on your local machine, which is a clone of the
   forked repository
 
To work on the NVSRehab Wordpress website files on your local machine,
fork the original repository to your own github account. Then clone
the forked repository to your local machine.

After modifying the site files on your local machine, transfer the
changes to the production server via ftp from your machine.

Submit the modified files from your local machine to github by
committing to your local repository and then pushing to the
forked github repository. Create a pull request in github from the 
fork to the original repository. In the original repository, accept
the pull request from the fork via the github gui.

If your account already has a forked repository, before modifying the
files you may wish to sync your fork with changes from the
original repository. If you sync with the original repository after 
modifying the files, you can merge or rebase before submitting further
changes to github.

Periodically backup the MySQL database to github by exporting the
database to an .sql file from phpMyAdmin. Push the file to the fork on
github and the original repository on github.


Copy the repository to a local machine
========================================

 * login to your github account.

 * if the nvsrehab_site repository is not already in your
   Repositories list, search for it with the search bar. Fork the
   nvsrehab/nvsrehab_site repository with the Fork button in the top 
   right corner. This will create a working copy of the repository 
   (project) in your account.  

 * if a repository copy is not already on your local machine, clone it
   on the commandline using the text in the SSH clone URL text box:
   > git clone git@github.com:'your-account'/nvsrehab_site.git

 * if the repository already exists on the local machine, obtain the
   most recent version of the files from the `nvsrehab/nvsrehab_site`
   repository with fetch or pull (pull includes checkout):
   >git fetch git@github.com:nvsrehab/nvsrehab_site.git


Update github fork with changes from the original repository
============================================================

 * on your local machine, obtain the most recent version of the 
   files from the original repository `nvsrehab/nvsrehab_site` 
   with fetch or pull (pull includes checkout):
   >git fetch git@github.com:nvsrehab/nvsrehab_site.git

 * make sure that you are on your master branch:
   >git checkout master

 * push the changes to the github fork
   >git push git@github.com:'your-account'/nvsrehab_site.git master


Update original repository with changes from github fork
========================================================

 * when you are ready to submit your local changes to the original
   repository, first update the github fork with changes from local
   machine:
   >git commit
   >git push git@github.com:'your-account'/nvsrehab_site.git

 * using the github gui, create a pull request from the fork to the
   original repository. 

 * in the original repository, accept the pull request from the fork
   via the github gui.
