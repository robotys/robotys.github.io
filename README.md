![saurus logo](images/saurus_logo.png)

SAURUS
======

Git to Blog: Blog engine for web developer.

USAGE
-----

We assume git and php has been installed and current directory is root of the localhost directory. Also assumed were we already has our own github.io page and we will deploy our blog there. Thus:

1. mkdir blog
2. cd blog
3. git init
4. git remote add origin git@github.com:username/username.github.io.git
5. git pull origin master
6. git remote add saurus https://github.com/robotys/saurus.git
7. git pull saurus master
8. _*make changes*_
9. git add -A
10. git commit -m 'first post'
11. git push origin master

Development Notes / Basic Concepts
----------------------------------

Main idea is a fork of jeckyl. Saurus will generate a 'semi-static' website given a markdown directory full of articles in markdown format.

### Semi Static Engine

Unlike jeckyl, Saurus WILL NOT generate the entirety of the html files. Meaning if you have like thousands of articles, it will not generate thousands of html file. That will be ridiculous!. I do not need extra hours everytime i need to publish new article just waiting the static files generate from my first of thousand post.

That is the main intention.

So, we achieve (more like we workaround) this target by leveraging ajax. We need semi-dynamic to achieve semi-static right?

### Reading Data Flow

Everytime user call a post via hashbang routing, let say http://blogonsaurus.com/#/read/markdown-example, there will be a function that will fetch the slug part and compare with index in json.

From there, we call the file needed from mds directory, parse it through markdown-html parser written in js, and then display it in body content.

### Saurus public generation

To generate the files and dirs, run gen.php from local Apache-PHP server. Can also frun from command line but where is the fun in that? Better to run in full Apache-PHP environment as we can check the files generated from localhost server directly before git the public directory to live server.

### Saurus User Case

Author a post in markdown format -> save in post directory -> run gen.php -> check from localhost/public for the changes -> git it upstream to live server

License: MIT