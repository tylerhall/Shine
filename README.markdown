# April, 2019 Update

I've been using Shine (and so have quite a few other Mac developers) to succesfully run my software business for the last ten years or so. Unfortunately, due to my own unique business requirements, I forked Shine privately for [my company](https://clickontyler.com) a long time ago. It's gained tons of new features and improvements, but most of them are tied to my own needs and haven't made their way back into the open source version. So, I'm archiving this repo.

I'm still more than happy to answer questions about the project and provide help and guidance for anyone using it or if you just have general questions about setting up a Mac software business outside the Mac App Store. Feel free to [contact me](https://tyler.io).

# About Shine

Shine is a web-based dashboard for indie Mac developers. It's designed to manage payment and order processing with PayPal and generate and email license files to your users using the [Aquatic Prime](http://www.aquaticmac.com/) framework. It even uploads each revision of your app into Amazon S3 and can produce reports from your users' demographic info (gathered via [Sparkle](http://sparkle.andymatuschak.org/)). It also serves as a central location to collect user feedback, bug reports, and support questions using the [OpenFeedback framework](http://github.com/tylerhall/OpenFeedback/tree/master).

This specific GitHub project is a complete rewrite of the previous version that was hosted on Google Code. Normally, I'm not an advocate of rewriting something that works, but in this case I felt it was needed. The original release (two years ago) was written in a very short period of time in a rush to release my first OS X application. This version uses an upgraded version of its PHP framework and is designed with future plans in mind.

Here's the [original blog post](http://clickontyler.com/blog/2009/08/shine-an-indie-mac-dashboard/) about the project if you're looking for a longer description.

Basic Usage
-----------
1. Unzip the installation folder into a non obvious directory on your web root directory.
2. Create a database, and import the mysql.sql file from the Shine folder.
3. Create a user in the 'users' table.
4. Rename /includes/class.config.sample.php to /includes/class.config.php and modify to suit your server settings.
5. Done, visit the webpage and login.

License
-------

This code is released under the MIT Open Source License. Feel free to do whatever you want with it.

Screenshots
-------
[![Screenshot 1](http://cdn.tyler.fm/blog/shine2-ss1-sm.png)](http://cdn.tyler.fm/blog/shine2-ss1.png)
[![Screenshot 2](http://cdn.tyler.fm/blog/shine2-ss2-sm.png)](http://cdn.tyler.fm/blog/shine2-ss2.png)
[![Screenshot 3](http://cdn.tyler.fm/blog/shine2-ss3-sm.png)](http://cdn.tyler.fm/blog/shine2-ss3.png)
[![Screenshot 4](http://cdn.tyler.fm/blog/shine2-ss4-sm.png)](http://cdn.tyler.fm/blog/shine2-ss4.png)
[![Screenshot 5](http://cdn.tyler.fm/blog/shine2-ss5-sm.png)](http://cdn.tyler.fm/blog/shine2-ss5.png)
