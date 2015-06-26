Albumgrab - Automated photo album crawler and downloader
========================================================

[![Build Status](https://travis-ci.org/adamelso/albumgrab.svg?branch=master)](https://travis-ci.org/adamelso/albumgrab)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/adamelso/albumgrab/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/adamelso/albumgrab/?branch=master)


What it is? What does it do?
----------------------------

A __command-line utility__ to __automate__ crawling through a photo album and __downloading all images__ within the album __on Facebook__.


Supported sites:

  * Facebook

Coming soon:

  * Twitter
  * Instagram
  * Tumblr
  * Flickr


Background
----------

Currently, there is no feature on Facebook to download all images in an album.
Someone would have to go through each and every photo and download them
one by one manually. I was required to download images a client had of their work
from Facebook so that they could be uploaded on their site. So I created this project.

This command line tool will automatically crawl through a photo album and save all the images.


Requirements
------------

  * PHP 5.4 or greater
  * Composer
  * Git
  * cURL


Roadmap
-------

  * At the moment it is only available as a command line utility, but could be available either as a website
    anyone can use, or an self-hosted installable web application.
  * Only Facebook is supported, but other sites will have support (see above for a list).
  * This project will be split out into different packages.
  * The installation process will be simplified by downloading a single packaged executable (PHAR).


Install
-------

```bash
$ git clone https://github.com/adamelso/albumgrab
$ curl -sS https://getcomposer.org/installer | php
$ php composer.phar install
```

Usage
-----

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

Please use responsibly and at your own risk, as [Facebook frown upon such tools](https://www.facebook.com/terms.php?ref=pf).

> 3.2. You will not collect users' content or information, or otherwise access Facebook, using automated means (such as harvesting bots, robots, spiders, or scrapers) without our prior permission.

