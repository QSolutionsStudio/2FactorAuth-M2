# Google Authenticator Integration for Magento 2

This module integrates Google Authenticator into Magento 2 admin panel, to provide two factor authentication for store managers.
 
## Features
 
* Two factor authentication for Magento 2 store administrators
* May be enabled / disabled per user
* Login instructions mailed to enabled users on feature activation / secret (re)generation
* Command-line interface
 
## Installation
 
You will need SSH access to your server.

Run the following commands in your Magento 2 root folder:

`composer config repositories.qextensions git https://github.com/QSolutionsStudio/2FactorAuth-M2.git`

(url will change for public version ofc)

`composer require qextensions/google2factor`

`php bin/magento module:enable Qextensions_Google2factor`

`php bin/magento setup:upgrade`

You have now enabled and installed the module, but in order to make it work, you need to configure it first.

## Configuration

Go to your store's configuration to enable the extension:

![config1](/screenshots/screenshot_config1.png)

![config2](/screenshots/screenshot_config2.png)

![config3](/screenshots/screenshot_config3.png)

![config4](/screenshots/screenshot_config4.png)

Then generate your secret code for Google Authenticator app:

![config5](/screenshots/screenshot_config5.png)

![config6](/screenshots/screenshot_config6.png)

Now new field will appear on login screen, although it won't be required until you enable two factor authentication for given user:

![config7](/screenshots/screenshot_config7.png)

In order to do that, go to your account settings:

![config8](/screenshots/screenshot_config8.png)

![config9](/screenshots/screenshot_config9.png)

This may be done for other users as well, from admin user edit form or via Magento's command line interface:
                                                                    
![config10](/screenshots/screenshot_config10.png)

All set, now you will be required to fill in the valid login code while signing into your Magento 2 dashboard:

![config11](/screenshots/screenshot_config11.png)