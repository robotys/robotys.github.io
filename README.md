SAURUS
======

Git to Blog: Blog engine for web developer.

INSTALLATION
============

Currently via github, download the zip package or just git it downstream. In the future will include composer too.

USAGE
=====

Coming soon


Development Notes
=================

Main idea is a fork of jeckyl. JSB will generate a 'semi-static' website given a markdown directory full of articles in markdown format.

## Semi Static Engine

Unlike jeckyl, JSB WILL NOT generate the entirety of the html files. Meaning if you have like thousands of articles, it will not generate thousands of html file. That will be ridiculous!. I do not need extra hours everytime i need to publish new article just waiting the static files generate from my first of thousand post.

That is the main intention.

So, we achieve (more like we workaround) this target by leveraging ajax. We need semi-dynamic to achieve semi-static right?

## Reading Data Flow

Everytime user call a post via hashbang routing, let say http://jsb.org/#!/read/markdown-example, there will be a function that will fetch the slug part and compare with index in json.

From there, we call the file needed from mds directory, parse it through markdown-html parser written in js, and then display it in body content.

## JSB public generation

To generate the files and dirs, run gen.php from local Apache-PHP server. Can also frun from command line but where is the fun in that? Better to run in full Apache-PHP environment as we can check the files generated from localhost server directly before git the public directory to live server.

## JSB User Case

Author a post in markdown format -> save in mds directory -> run gen.php -> check from localhost/public for the changes -> git it upstream to live server

License: MIT