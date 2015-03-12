Devise Bootstrap
======

[![Latest Stable Version](https://poser.pugx.org/devisephp/cms/v/stable.svg)](https://packagist.org/packages/devisephp/cms)
[![Total Downloads](https://poser.pugx.org/devisephp/cms/downloads.svg)](https://packagist.org/packages/devisephp/cms)
[![Latest Unstable Version](https://poser.pugx.org/devisephp/cms/v/unstable.svg)](https://packagist.org/packages/devisephp/cms)
[![License](https://poser.pugx.org/devisephp/cms/license.svg)](https://packagist.org/packages/devisephp/cms)

##About

The Devise Bootstrap is the official bootstrapped application for the [Devise](http://github.com/devisephp/cms) content management system. Think of this as a blank slate for your application with everything you need to get started. Every night we rebuild this application so that you can download the entire application *and all dependencies*.

If you are new to Devise this is the easiest way to get started. Just click on "Download Zip" button above or [click here](https://github.com/devisephp/bootstrap/archive/master.zip). Drop it on a server and then choose your install method.

### Full Documentation

Full documentation can be found at [http://devisephp.com/docs](http://devisephp.com/docs)

### General Install on [Homestead](http://laravel.com/docs/5.0/homestead)

Homestead is a virtual machine created by the team behind Laravel. You can use any host you like but Homestead provides an Ubuntu sandbox that bridges files to and from your host machine. If you've never used it before follow the instructions [here](http://laravel.com/docs/5.0/homestead). It's worth the download time to get up and running. 

Once you're all setup and can ssh into your box follow these steps:

1. Create your new site entry in your ```Homestead.yaml```

```
- map: new-domain.com
  to: /home/vagrant/Code/new-domain/public
```

2. Add your domain to your ```/etc/hosts```

3. From ~/Homestead: ```vagrant reload --provision```

4. Unzip the [latest build](https://github.com/devisephp/bootstrap/archive/master.zip) into your Homestead directory.

5. If your database user does not have CREATE permissions you will need to create the database we will install to.

### Install From Browser

Installing from a browser is very easy. Just go to your domain (http://new-domain.com:8000 in this example - 8000 is the port Homestead listens on) and you will be redirected to the installer

1. Click get started on the welcome screen.

2. Select or set the appropriate environment. This is really up to you and simply sets the name of the environment you are installing to. For instance: If you are working on your own computer you probably want to select "local" and if you're working on the final server you probably want to select "production"

3. Provide the appropriate database settings. If the user you provide has CREATE DATABASE privileges then Devise will create the database for you.

4. Provide the administrators email, username, and password. The password must be at least 8 characters in length.

After clicking next Devise installs it's migrations and seeds into your database and forwards you to the administration screen.

### Install From Command Line

From the root of your project: ```php artisan devise:install``` and follow the prompts which are very similar to the steps above.

### What now?

Well, that depends on what it is that you want to create. If it's a simple site that only needs content management then you probably just want to import some templates and sprinkle some ```data-devise``` attributes throughout your code. If it's more application centric then you can connect your front-end to your classes through the API section.

If you're totally lost we strongly suggest you check out the [Brewers & Beers](https://github.com/devisephp/example) project which has several examples of what you can do in Devise.

### Feedback

Please give us your feedback on Devise and the Devise Bootstrap at [info@devisephp.com](info@devisephp.com)

### License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
