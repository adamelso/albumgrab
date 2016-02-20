Feature: Downloading images from a Facebook photo album
  In order to be able to download photos from an Instagram profile without inspecting element
  I want to automate the downloading of photos for a whole album
  As a user

  Scenario: Downloading and saving photos from Facebook
    Given I am in the Albumgrab app directory
    When I run the Albumgrab "download from instagram" command
    And when asked which directory to save to I answer "/tmp/travelgram"
    And when asked the URL to the Instagram profile I answer "https://www.instagram.com/travelgram/"
    Then it should print:
    """
    Downloading 6 images.
    6 images saved to "/tmp/travelgram".
    """
