Albumgrab - Automated photo album crawler and downloader
========================================================

[![Build Status](https://travis-ci.org/adamelso/albumgrab.svg?branch=master)](https://travis-ci.org/adamelso/albumgrab)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/adamelso/albumgrab/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/adamelso/albumgrab/?branch=master)


UPDATE !
--------

Sadly, the Facebook album download feature no longer works since the page structure has changed
and so this tool is effectively useless at this time.
However, new crawlers will be added for other sites, such as Instagram and Twitter.


Requirements
------------

  * PHP 7.0 or greater
  * Composer
  * Git
  * cURL
  * V8
  * V8js PHP extension


Roadmap
-------

  * At the moment it is only available as a command line utility, but could be available either as a website
    anyone can use, or an self-hosted installable web application.
  * Support Facebook, Twitter and Instagram.
  * This project will be split out into different packages.
  * The installation process will be simplified by downloading a single packaged executable (PHAR).


Install
-------

```bash
$ git clone https://github.com/adamelso/albumgrab
$ curl -sS https://getcomposer.org/installer | php
$ php composer.phar install
```

Usage (currently not functional)
--------------------------------

Enter the Albumgrab directory

```bash
$ cd albumgrab
```

Then execute the app

```bash
$ bin/albumgrab download
```

You will then be prompted to provide the folder/directory name you want the images to be saved to, followed by the URL/link to first image in the album.

    Please enter the name of the directory your images will be saved to:
        images/summer-2014
    Please enter the URL to the first image of the Facebook Photo Album you would like to download:
        https://facebook.com/photo.php?fbid=11111&set=a.222.333.444


Not using Facebook in English
-----------------------------

The crawler will look for a link labeled _Next_ to find the next image.
If your Facebook is in another language, please run the command using
the `-x` or `--next` option, with the equivalent word for _Next_ in
your language.

Example for Spanish:

```bash
$ bin/albumgrab download --next="Siguiente"
```

or

```bash
$ bin/albumgrab download -x Siguiente
```


IMPORTANT
---------

Please use responsibly and at your own risk.
