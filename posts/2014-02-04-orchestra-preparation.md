# Orchestra Preparation

Trying orchestra or laravel, and you will be humbled by its preparation requirement. So, here are the checklist and accompanying snippet to prep your OSX to ready for it.

Yep, OSX. Windows will come after this.

	it is hard for me because i am noob. When you develop PHP app from MAMP and your team consist of you ONLY, you are noob. This exercise made me so humble i want to cry. TT____TT . Now, not anymore ^__^

My environtment: OSX, installed MAMP and working fine with PHP 5.4.10.

## Step 00: Some background

Every code start with '$' is meant to be used in terminal. (You do know what is terminal do you? Too much noob if not). And i will use [Sublime Text](http://www.sublimetext.com/) as my code editor. It is cool!

If in terminal you face with 'permission denied' kind of error, most probably you need to use 'sudo [your command here]'.

## Step 0: Make sure your php path is right

Find where your php binary resides:

	$ which php

if it shows other than

	$ which php
	/Application/MAMP/bin/php/php5.4.10/bin/php

Then we need to make it point to that path. Meaning we need to edit the environment path within .bash_profile.

Check is there any .bash_profile within home directory (~)

	$ ls -A ~

create one in your home directory if there is none:

	$ touch ~.bash_profile

open up that file in your favourite editor (did i mention to use sublime text 2? Go and download it now if you do not have it yet). Add this 2 liner AFTER any other export if you have:

	export MAMP_PHP=/Applications/MAMP/bin/php/php5.3.6/bin
	export PATH="$MAMP_PHP:$PATH"
    

And now we validate it again:
	
    $ which php
    /Application/MAMP/bin/php/php5.4.10/bin/php
    $ php -v
    PHP 5.4.10 (cli) (built: Jan 21 2013 15:12:32) 
	Copyright (c) 1997-2012 The PHP Group
	Zend Engine v2.4.0, Copyright (c) 1998-2012 Zend Technologies

We are now ready!

ps: why we need MAMP, why not use the pre-installed php? Yes you can, but for me when i try using composer, it throw an error 'Composer need Mcrypt PHP Module'. I know that my MAMP already have that installed, so it is easier to use MAMP php instead of installing that module into the pre-installed php. Or maybe not.

## Step 1: Install and configure Composer

Composer is mainly the things that bring the headache to noob like me. It is because we are so used to downloading a zip file, extract it and then use the script in our codes. We can live with that, except when we use so many script one big hairy ball of problem start to facing its head: dependencies.

Dependencies is when a script need another script to working fine. Assume the worst: we have nested of dependence. This script need another script which need another script which need the same script previously but different versio and on and on.

Thats where composer came in. It manage the dependencies for us. Just tell it what to use and it will download all the needed script which already preconfigured to working just fine with its dependencies.

	seriously, i need to use it to understand it. Because in all my php-ing, i never face these dependencies problem. Maybe because  i use only Codeigniter and no other framework, like Symfony. Yeah, like Symfony maybe

Ok, lets start:

First we need to download the .phar file from composer site. 

Nope, before that if you are not familiar with .phar file, then read the following paragraph. If you are familiar (hye not noob!) then just skip it.

.phar is essentially a packaged php class that can be run from command line and act like any shell script. Thus it is a very handy new thing from php 5.4.* it make something like composer possible! (and artisan too!)

To install, the guy at getcomposer.org has give us simple on liner command line installer. Type this into terminal and hit enter:

	$ cd /Application/MAMP/htdocs
    $ curl -sS https://getcomposer.org/installer | php -- --install-dir=bin

Done!

validate the installation:

	$ which composer
    /Applications/MAMP/htdocs/bin/composer
    $ composer --version
    Composer version 75cd91657abaf314f4b49bd3d9a991fb85b4079d 2014-02-05 08:53:49

If that is what you saw, then lucky you. If not, then lucky to you too. Now you need to fish the solution in the vast ocean of internet. Good luck.

## Final step: Install Git

Git is version control system. That is a fancy name for something that will track/save all your codes incrementally so that when something happens, you still have your previous/current code.

It makes working on code with other people easy, save and cheap.

Think it like this: Git is the tools that will make your future self thank you. A LOT.

Another reason why: composer like you to have git. It is because that is the tool that it will use to download file from packagist. Figure out packagist from google please.

Lets install it, err git:

Download the package from [git download](http://git-scm.com/download) page or directly download [git for mac](http://git-scm.com/download/mac).

Double click and follow the installation instruction. Done!

Validate it from terminal:

	$ which git
    /usr/bin/git
    $ git --version
    git version 1.8.3.4 (Apple Git-47)

And now you are ready to follow the orchestra platform tutorial! I would start with [Simple Website with Orchestra Platform 2 (Part 1)](http://orchestraplatform.com/blogs/2013/06/01/simple-website-1/)