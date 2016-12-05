**Instagram plugin**
==
Instagram Widget extension provides ability to display only approved instagram images on any page. 
Images can be downloaded and selected to be appear from admin panel. Each product can be attached to every image.

**Backend**
--
System -> Configuration -> Instagram Settings

    Client ID - var provided by instagram.
    Client Secret - var provided by instagram.
    Access Token - automatically fill out by the system.
    Tag name - tag name.
    Post count - count of the posts that will be visible.

**Frontend**
--
For pop-up system is using "jquery.fancybox" library 

**Key Features**
==
* Can be placed anywhere on a store 
* Any number of blocks(containing image) can be shown
* Description can be changed
* Showing only approved images

**Installation**
==
To install this extension you need to execute the following commands:

    modman init
    modman clone git@github.com:thecvsi/magento-instagram-images.git

To update this extension to the latest version you need to execute the following command:

    modman update magento-instagram-images