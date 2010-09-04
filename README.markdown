![Shine Logo](http://static.clickontyler.com/blog/shine.png)

Shine is a web-based dashboard for indie Mac developers. It's designed to manage payment and order processing with PayPal and generate and email license files to your users using the [Aquatic Prime](http://www.aquaticmac.com/) framework. It even uploads each revision of your app into Amazon S3 and can produce reports from your users' demographic info (gathered via [Sparkle](http://sparkle.andymatuschak.org/)). It also serves as a central location to collect user feedback, bug reports, and support questions using the [OpenFeedback framework](http://github.com/tylerhall/OpenFeedback/tree/master).

This specific GitHub project is a complete rewrite of the previous version that was hosted on Google Code. Normally, I'm not an advocate of rewriting something that works, but in this case I felt it was needed. The original release (two years ago) was written in a very short period of time in a rush to release my first OS X application. This version uses an upgraded version of its PHP framework and is designed with future plans in mind.

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
[![Screenshot 1](http://cdn.tyler.fm/blog/shine-ss2-sm.png)](http://cdn.tyler.fm/blog/shine-ss2.png)
[![Screenshot 2](http://cdn.tyler.fm/blog/shine-ss3-sm.png)](http://cdn.tyler.fm/blog/shine-ss3.png)
[![Screenshot 3](http://cdn.tyler.fm/blog/shine-ss4-sm.png)](http://cdn.tyler.fm/blog/shine-ss4.png)
[![Screenshot 4](http://cdn.tyler.fm/blog/shine-ss5-sm.png)](http://cdn.tyler.fm/blog/shine-ss5.png)
[![Screenshot 5](http://cdn.tyler.fm/blog/shine-ss6-sm.png)](http://cdn.tyler.fm/blog/shine-ss6.png)
[![Screenshot 6](http://cdn.tyler.fm/blog/shine-ss7-sm.png)](http://cdn.tyler.fm/blog/shine-ss7.png)
