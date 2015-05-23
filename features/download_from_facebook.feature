Feature: Downloading images from a Facebook photo album
  In order to save time by not manually visiting each page in a Facebook album and downloading its image
  As a user
  I want to automate the downloading of photos for a whole album

  Scenario: Downloading and saving photos from Facebook
    Given I am in the Albumgrab app directory
    When I run Albumgrab
    And when asked which directory to save to I answer "/tmp/php-london"
    And when asked the URL to an image in a photo album I answer:
"""
https://www.facebook.com/PeeHPLondon/photos/pb.7119218495.-2207520000.1430669248./10153559172718496/?type=3&src=https%3A%2F%2Ffbcdn-sphotos-g-a.akamaihd.net%2Fhphotos-ak-xfp1%2Fv%2Ft1.0-9%2F10986697_10153559172718496_5727444485530442900_n.jpg%3Foh%3Dc47770f4cd15fecc6888bcd504899087%26oe%3D55DA9CB0%26__gda__%3D1439174101_7c78a93bf247dbad6c56681b6db5309c&size=960%2C959&fbid=10153559172718496
"""
    Then it should print:
"""
Please enter the name of the directory your images will be saved to. This can be an absolute path (eg: "/tmp/fbphotos"). Otherwise, relative paths will be relative to the "images" directory.
/tmp/php-london
Please enter the URL to the first image of the Facebook Photo Album you would like to download.
https://www.facebook.com/PeeHPLondon/photos/pb.7119218495.-2207520000.1430669248./10153559172718496/?type=3&src=https%3A%2F%2Ffbcdn-sphotos-g-a.akamaihd.net%2Fhphotos-ak-xfp1%2Fv%2Ft1.0-9%2F10986697_10153559172718496_5727444485530442900_n.jpg%3Foh%3Dc47770f4cd15fecc6888bcd504899087%26oe%3D55DA9CB0%26__gda__%3D1439174101_7c78a93bf247dbad6c56681b6db5309c&size=960%2C959&fbid=10153559172718496
Opening https://www.facebook.com/PeeHPLondon/photos/pb.7119218495.-2207520000.1430669248./10153559172718496/?type=3&src=https%3A%2F%2Ffbcdn-sphotos-g-a.akamaihd.net%2Fhphotos-ak-xfp1%2Fv%2Ft1.0-9%2F10986697_10153559172718496_5727444485530442900_n.jpg%3Foh%3Dc47770f4cd15fecc6888bcd504899087%26oe%3D55DA9CB0%26__gda__%3D1439174101_7c78a93bf247dbad6c56681b6db5309c&size=960%2C959&fbid=10153559172718496
Image found 10986697_10153559172718496_5727444485530442900_n.jpg
1
https://www.facebook.com/PeeHPLondon/photos/pb.7119218495.-2207520000.1430669248./10153556325428496/?type=3&permPage=1
Image found 11016077_10153556325428496_8375118985971489219_n.jpg
2
Opening https://www.facebook.com/PeeHPLondon/photos/pb.7119218495.-2207520000.1430669248./10153451313928496/?type=3&permPage=1
Image found 10636330_10153451313928496_5638602346728012061_n.jpg
3
Opening https://www.facebook.com/PeeHPLondon/photos/pb.7119218495.-2207520000.1430669248./10153451313738496/?type=3&permPage=1
Image found 1425527_10153451313738496_770396378788043344_n.jpg
4
Opening https://www.facebook.com/PeeHPLondon/photos/pb.7119218495.-2207520000.1430669248./10153355298753496/?type=3&permPage=1
Image found 10624770_10153355298753496_1635835635861794091_n.jpg
5
Opening https://www.facebook.com/PeeHPLondon/photos/pb.7119218495.-2207520000.1430669248./10153337558463496/?type=3&permPage=1
Image found 10849893_10153337558463496_7919878746109829279_n.png
6
Opening https://www.facebook.com/PeeHPLondon/photos/pb.7119218495.-2207520000.1430669248./10153337557468496/?type=3&permPage=1
Image found 10518582_10153337557468496_2057680628612984927_o.jpg
7
Opening https://www.facebook.com/PeeHPLondon/photos/pb.7119218495.-2207520000.1430669248./10153337530568496/?type=3&permPage=1
Image found 10858630_10153337530568496_152071575302062213_n.png
8
Opening https://www.facebook.com/PeeHPLondon/photos/pb.7119218495.-2207520000.1430669248./10484443495/?type=3&permPage=1
Image found 10398928_10484443495_110_n.jpg
9
Opening https://www.facebook.com/PeeHPLondon/photos/pb.7119218495.-2207520000.1430669248./10484438495/?type=3&permPage=1
Image found 10398928_10484438495_9838_n.jpg
10
Opening https://www.facebook.com/PeeHPLondon/photos/pb.7119218495.-2207520000.1430669248./10153559172718496/?type=3&permPage=1
Image found 10986697_10153559172718496_5727444485530442900_n.jpg
11
Opening https://www.facebook.com/PeeHPLondon/photos/pb.7119218495.-2207520000.1430669248./10153556325428496/?type=3&permPage=1
Found 11 images
File saved to "/tmp/php-london/10986697_10153559172718496_5727444485530442900_n.jpg"
File saved to "/tmp/php-london/11016077_10153556325428496_8375118985971489219_n.jpg"
File saved to "/tmp/php-london/10636330_10153451313928496_5638602346728012061_n.jpg"
File saved to "/tmp/php-london/1425527_10153451313738496_770396378788043344_n.jpg"
File saved to "/tmp/php-london/10624770_10153355298753496_1635835635861794091_n.jpg"
File saved to "/tmp/php-london/10849893_10153337558463496_7919878746109829279_n.png"
File saved to "/tmp/php-london/10518582_10153337557468496_2057680628612984927_o.jpg"
File saved to "/tmp/php-london/10858630_10153337530568496_152071575302062213_n.png"
File saved to "/tmp/php-london/10398928_10484443495_110_n.jpg"
File saved to "/tmp/php-london/10398928_10484438495_9838_n.jpg"
File saved to "/tmp/php-london/10986697_10153559172718496_5727444485530442900_n.jpg"

"""
