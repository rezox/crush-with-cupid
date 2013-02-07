# Crush With Friends

Tell us who you want to go out with out of your friends and if we find a match we'll hook you up! We'll even give you some cool dating offers!

## How to use

First clone the repo and the submodules.

    git clone git@bitbucket.org:sjlu/crush-with-friends.git
    cd crush-with-friends
    git submodule update --init
   
Make sure you have Node.js installed. I like to use [Homebrew](http://mxcl.github.com/homebrew/) for Mac to install Node.js and npm.
   
Next, install Grunt.

    npm install -g grunt
   
Then, in the project directory, we need to grab the grunt dependencies.

    npm install
   
Good to go! Now all you need to do is run `grunt` anywhere in your directory and your LESS and JS files will be compiled every time you save.

Okay, now if you want you should probably add this to your virtual hosts.

	# Crush with friends
	<VirtualHost *:80>
	 DocumentRoot "/Users/sjlu/Web/crush-with-friends"
	 ServerName dev.crustwithfriends.com

	 <Directory "/Users/sjlu/Web/crush-with-friends">
	     Options Indexes MultiViews FollowSymLinks
	     AllowOverride All
	     Order allow,deny
	     Allow from all
	 </Directory>
	</VirtualHost>