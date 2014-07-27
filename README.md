Album Grab - Facebook Photo Album Downloader
============================================

I had a client who's images she wanted on her website were all in a photo album
on her Facebook page. Unfortunately there was not an option to download them
all. Someone would have to go through each and every photo and download them
one by one manually. So I created this project.

This command line tool will crawl through a photo album and save all the images
automatically.

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
$ ./albumgrab
```

You'll then be prompted to provide the folder/directory name you want the images to be saved to, followed by the URL/link to first image in the album.

    Please enter the name of the directory your images will be saved to: images/summer-2014
    Please enter the URL to the first image of the Facebook Photo Album you would like to download: https://facebook.com/photo.php?fbid=11111&set=a.222.333.444


Notes
-----

This project needs a bit of a code refactoring, plus cover some missing edge cases.


IMPORTANT
---------

Please use responsibly and at your own risk, as [Facebook frown upon such tools](https://www.facebook.com/terms.php?ref=pf).

> 3.2. You will not collect users' content or information, or otherwise access Facebook, using automated means (such as harvesting bots, robots, spiders, or scrapers) without our prior permission.

