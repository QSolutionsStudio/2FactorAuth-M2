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

`composer config repositories.qssdev git https://wojciechmwnuk@bitbucket.org/qssdev/qss_googleauth.git`

(url will change for public version ofc)

`composer require qssdev/qss_googleauth`

`php bin/magento module:enable QSS_GoogleAuth`

`php bin/magento setup:upgrade`

You have now enabled and installed the module, but in order to make it work, you need configure it first.

## Configuration

In progress.