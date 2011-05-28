montrain.fr
===========

Simple, stable and unauthenticated instant messaging service for train users.


About
-----

After noticing that people use their smartphones on trains on a daily basis but don't talk to each other, I decided to try and create a simple instant messaging service. 
This service is extremely simple :

* no authentication
* no multimedia 
* no social networking

Just load and talk with your train mates.

Technologies
------------

Web basics are used :

* [Symfony 1.4](http://www.symfony-project.org/)
* [jQuery 1.5](http://jquery.com/)

Setup
-----
1. Fork it.
2. Create a MySql database.
3. Copy `config/databases.yml.dist` into `config/databases.yml` and configure it with your database connexion infos.
4. Copy `propel.ini.dist` into `propel.ini` and configure only `propel.database.url`
5. Set permissions : `./symfony project:permissions`
6. Load fixtures : `./symfony propel:build-all-load --no-confirmation`
5. Configure your web server and restart it.

Contributing
------------

1. Create a branch : `git checkout -b my_branch`
2. Commit your changes : `git commit -am "Added new features"`
4. Push to the branch : `git push origin my_branch`
5. Create an [issue](http://github.com/KuiKui/montrain.fr/issues/new) with a link to your branch.
