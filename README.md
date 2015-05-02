Albumgrab - Facebook Photo Album Downloader
============================================

Background
----------

Currently, there is no feature on Facebook to download all images in an album.
Someone would have to go through each and every photo and download them
one by one manually. I was required to download images a client had of their work
from Facebook so that they could be uploaded on their site. So I created this project.

This command line tool will automatically crawl through a photo album and save all the images.


Roadmap
-------

At the moment it's only available as a command line utility, but soon will be available as a website anyone can use.


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
$ bin/albumgrab
```

You'll then be prompted to provide the folder/directory name you want the images to be saved to, followed by the URL/link to first image in the album.

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
$ bin/albumgrab --next="Siguiente"
```

or

```bash
$ bin/albumgrab -x Siguiente
```


Notes for developers
--------------------

This project needs a bit of a code refactoring, plus cover some missing edge cases.


IMPORTANT
---------

Please use responsibly and at your own risk, as [Facebook frown upon such tools](https://www.facebook.com/terms.php?ref=pf).

> 3.2. You will not collect users' content or information, or otherwise access Facebook, using automated means (such as harvesting bots, robots, spiders, or scrapers) without our prior permission.

