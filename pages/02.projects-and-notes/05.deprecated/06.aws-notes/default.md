---
title: 'AWS Notes'
---

!! These are historical notes and are likely out of date.

1. - start the required AWS Amazon account. Go to the EC2 area.

2. - Launch the "Instance Wizard", preferably in classic mode. This will allow you to locate your server in a specific data center. Currently only US East available.

-Select an Amazon AMI Basic 64-bit.

-Select 1 t1.micro instance, as those are free.

-Turn on Termination Protection

-Leave Shutdown Behavior on Stop

-To right of Name, set friendly name, like "MicroPenguin".

-Create a new KeyPair. Download the .pem file locally.

-Select your default Security Group

-Verify and Launch

You now have a Virtual Server instance. It is as "bare bones" as possible, except for a few tools on it to make it easier to connect other Amazon services. We are creating a LAMP setup for Wordpress, and we now have the "L" in LAMP underway.

3. - Configure the Amazon Firewall. Click Security Groups. Click Default for your current environment. Click Inbound. Click on the Create a New Rule, and select the following:

```php
SSH (22)

HTTP (80)

3306 (MySQL)

Custom (20-21)

Custom (10000)
```

These may not be the only holes you want to punch in the firewall, but for Wordpress and later installs, this will be enough. If you add any additional services that require more port openings, you must do that through this area. Go back to Instances and insure that "default" or whatever the group is called is attached to your running instance of Linux.

4. - Click on Volumes. Click on the "empty" drive that is now in-use. Click Tags, and on the right of Name, add a friendly name like "LAMP Drive", etc. Don't detach drives that are main drives, as the instance won't start. (If you do, it must be remounted as sha1.)

5. - Go to Elastic IPs. Allocate a new address. The EIP (Elastic IP) will be used in EC2\. Make sure you like this number. It's your IP, and while not difficult to change later in EC2, it will be used extensively. See if you can get a reasonably memorable IP number. You can "catch and release" a few dozen times before being charged.

6. - When you have an IP you're ok with, select it, and choose Associate Address. Select your instance, which should be just your one server. Note the friendly name appears here. Also, make note of your IP address; you're about to use it extensively.

A quick drop of the IP address in a browser will prove that there is no web server running. This completes everything you need to do in the Amazon control panel. Just ensure you have your .pem KeyPair, and your IP address. Linux is up and running.

This linux Amazon AMI is "headless", meaning there is no user interface. This isn't like windows or mac, or even desktop linux. Everything is done from the command line. While this scares everyone at first that hasn't worked with a command line system, it's not that bad. It took me a while and several inquiries to understand that it runs without a UI, since I was so comfortable with Windows Server. It's not like that at all, and in its own way, that's a good thing. We will be putting in a UI of sorts, but for the start, everything is done by typing.

Now that the server exists, you'll want to start adding the necessities. This is done on the terminal level. I'm a Mac Coda user, so I'm going to explain how to do that. Other terminal entry is very similar, so this should still explain most of what you need.

\*Geek note - Amazon does not allow you to ever log in as "root". It's a security issue, and as such, you'll log in using a key pairing to start. Essentially, it's a user name and \*file\* that works \*as\* your password.

7. - Open the Mac Terminal. Type in the following:

```sh
open ~/.ssh
```

This opens what is normally a hidden folder on a Mac. The .pem file should be placed in this folder. Set this to 400 permissions.

Open TextEdit, or any text editor. Create a file called “config”. This should not have a file extension, so config.txt, config.rtf, etc., is incorrect. Just “config”. In that file, create four lines:

```sh
Host FriendlyLinuxNameYouMade

User ec2-user

IdentityFile ~/.ssh/YourKeyPair.pem

HostName your.ip.address.here

```

So an old version of mine looked like:

```sh
Host Penguin

User ec2-user

IdentityFile ~/.ssh/ChavezKeyPair.pem

HostName 107.22.192.162

```

Save this doc. Also, the returns between the lines are necessary. Copy-Paste this for good luck. :)

8. - Launch Coda

From here out, I’m going to use Coda as my terminal client. You don’t need to do this; any terminal will work, but for me, this is more convenient. I can also work from more than just terminal, so it’s my one-stop app for web.

In Coda, Add Site.

Give the Site a nickname, and maybe you’ll want to match your Micro instance nickname for now. I do “Name AMI” so I can easily see what kind of site I’m working with. 

Go to the Terminal area, and look for SSH Server. In this box, you’ll add the exact friendly name you had in your config file. Even though it says “domain.com” in the example text, ignore it and put the precise text name from config. The port is 22 (remember that firewall hole?). Do not add a user name or password. In short, Coda’s terminal will be looking at that config file. Click Save.

If you’re using a direct terminal, just go to AWS, select the instance, and click Instance Actions \> Connect. It will generate the correct code automatically, but it goes like this:

ssh -i YOURKeyPair.pem ec2-user@234.234.234.345

You just substitute your key and ip. (Ec2-user is a constant.)

Under Coda, click connect, and you’re in. On Terminal, you’ll have to answer yes to a question about security, then you’ll be in.

If you see ASCII Art like this:

```
   __|  __|_  )
   _|  (     /   Amazon Linux AMI
  ___|\___|___|
```

You have successfully connected.

9. - I’m in, now what?

We’re now L but not AMP. We’re missing a web server, and the web server of choice for Linux is Apache. Many builds of linux, and even Mac OS X comes with Apache baked in. But not Amazon - this is really, really bare bones. So let’s install Apache. This is easy; just copy this code in exactly:

```sh
sudo su

yum install httpd

```

Say yes when asked.

What did you just do? It took me a while to figure this out. The sudo su is basically upgrading you from basic permissions to “superuser” permissions while you’re logged in. This is acceptable because you have the super-secret key pair. After you give yourself the proper permissions, yum is a linux installer. You asked it to go grab “httpd”, which is a kind of nickname for apache. It’s an “HTTP Daemon”, or it serves web content. Clever. You’ll see that httpd is the folder it is installed in. Most self-references for Apache go to httpd.

Fancy! Now what?

Check to see that the web server is in fact running.

```sh
service httpd status

```

Not running yet? Ya, you need to explicitly start it.

```sh
service httpd start

```

If it’s running, you’re good. It’ll say httpd (pid \#\#\#) is running. It’s saying Apache, assigned process id number x, is running.

OK, want to be sure it’s running? Drop your IP address into a browser, and you will now see the Apache test page. Sweet! You have a Linux Apache box. Two more…

10. - Time for pre-processing

You have a static server at this point. Time for “M”, or MySQL. This of course is a database, and as such, a place to store things like articles, content, pages, and other such goodies that Wordpress and other things like to store data in.

In terminal, add the following lines:

```sh
yum install mysql mysql-server

service mysqld start

mysql_secure_installation

```

If you want to use Navicat:

```sh
mysql -u root -p
mysql> GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' IDENTIFIED BY 'bkpit97' WITH GRANT OPTION;
mysql> FLUSH PRIVILEGES;
mysql> exit

```

===== 

Don’t forget the d on mysqld - that is not a typo. It’s “MySQL Daemon”, same as httpd. This is the server daemon, dishing out data.

Service mysqld status should confirm a running instance of MySQL. 

 Complete! 

[root@ip-10-228-23-35 var]\# service mysqld start

Initializing MySQL database: Installing MySQL system tables...

OK

Filling help tables...

OK

To start mysqld at boot time you have to copy

support-files/mysql.server to the right place for your system

PLEASE REMEMBER TO SET A PASSWORD FOR THE MySQL root USER !

To do so, start the server, then issue the following commands:

```sh
/usr/bin/mysqladmin -u root password 'new-password'
/usr/bin/mysqladmin -u root -h ip-10-228-23-35 password 'new-password'

```

Alternatively you can run:

```sh
/usr/bin/mysql_secure_installation
```

which will also give you the option of removing the test

databases and anonymous user created by default. This is

strongly recommended for production servers.

See the manual for more instructions.

You can start the MySQL daemon with:

```sh
cd /usr ; /usr/bin/mysqld_safe &
```

You can test the MySQL daemon with [mysql-test-run.pl](http://mysql-test-run.pl)

```sh
cd /usr/mysql-test ; perl mysql-test-run.pl
```

Please report any problems with the /usr/bin/mysqlbug script!

11. - The pre-processor

```sh
yum install php php-mysql

```

Again, say y for yes

This directly installs PHP with support built in for working with MySQL. This completes the “LAMP Stack”. PHP is installed, but does not run as a server. It acts as an interpreter when data goes in and out of the web server, so there is no associated service to run.

A needed addition is some additional library files for image processing in PHP:

------

```sh
yum install php-gd



yum install php-xml



yum install php-mbstring

```

New information… in an attempt to resolve mbstring problems, I did:

```sh
yum install php55-gd
```

12. - It gets easier

At this point, the web server still isn’t terribly useful, since it’s just serving a regular ol’ test page that you can’t get to. The remaining steps of configuring your LAMP server are intended to make things easier on you, the administrator. There are three remaining steps I’ll go through here.

\*Webmin - a UI for machine administration

\*vsftpd - an FTP application

\*Wordpress - finally, the whole point, right?

```sh
echo -e "[Webmin]\nname=Webmin Distribution Neutral\nbaseurl=http://download.webmin.com/download/yum\nenabled=1" > /etc/yum.repos.d/webmin.repo

rpm --import http://www.webmin.com/jcameron-key.asc

yum install webmin

```

Copy and paste the preceding text into the terminal, and you’ll then download an application called Webmin. The purpose of Webmin is to give you a lot of options using a webpage, and allowing you to avoid the terminal on a day to day basis. For example, if you wanted to reboot, this is a couple of clicks instead of running down a command like shutdown -r now. I still don’t know how regular human beings are supposed to get used to command line structures, but Webmin goes a long way towards taking the confusion out.

Here’s the strange part. Unlike most linux installations, Webmin takes a little trick to get started on Amazon. Maybe you recall the Geek Note from earlier, but Amazon AMIs don’t allow you to log in with the ‘root’ user. Webmin is set up so that root is the way to go. So to fix this, you’ll do the following:

```sh
/usr/libexec/webmin/changepass.pl /etc/webmin root YOURpass_word

```

<https://your.ip.address:10000>

Go to your ip address, and recall we punched a hole in the firewall at port 10000 for Webmin. You may be greeted with a “missing certificate”, or a “do you want to continue”, etc., and yes, you do.

Once through, a Webmin login and password will be required. They are of course what you just set; root and your password.

13. - vsftpd

Yum install vsftpd will install the ftp daemon. This is straight ahead, and remember, there’s a hole punched in 20 and 21.

Setup for ftp is critical, and the most important part is permissions. FTP is a service, and the service is already attached to the users you’ve created, or already existed in the user list of the virtual machine. Everyone can FTP in, except for those users on the “excluded list”. The exclusions are by default most of the users that are already present. Those accounts are not usually used by outsiders; usually humans are assigned non-included accounts.

In webmin, go to Users and Groups, and add a new user. Call this user wwwroot, and assign a password. This user is now in need of a “home”. Under home directory, select /var/www/html and then set a “normal” password. Save the user, and when you go back to logins, you’ll see this user with an id of 500 (or higher).

This user now can log into the machine using FTP. When the user logs in, it sends the file system to the default folder for the Apache web daemon.

```sh
cd ~/                <- back to root

cd /var/www               <- to the containing directory

chown -R apache:apache html         <- allow the web service control over the files in the html folder

chown -R wwwroot:wwwroot html     <- give your ftp login control over the same files in the html folder

```

Connect via ftp

(If in terminal, it’s ftp your.ip.address)

You should see several hidden files, though it may take a moment due to an FTP timeout. This is expected. Make sure you do not use “Passive FTP”. You can later configure passive FTP, but that’s out of this tutorial’s scope. The hidden files start with a period, and won’t appear using FTP on terminal. If you don’t see them, you may not be showing hidden folders. Within this folder, create an index.html, and add a “hello world” statement.

Test that you can see the file in a web browser. If you set your IP address, it should automatically pick up your new Hello World! page.

Remember, you installed it and added ftpftp, with pw ftpftpftpftp

14. - LAMP'd

OK, take a deep breath. The environment is built! Here’s the checklist of accomplishments so far:

Created a Linux box and logged in

Installed Apache

Installed MySQL

Installed PHP

Installed FTP

Installed Webmin

Connected, and uploaded a test html page

Hey, that’s not bad! From here forward, it’s about Wordpress. If you want to install other things, other CMS packages, or you’re happy to doddle away with your current system, which is FREE and FAST, have fun! The last segment will talk about the CMS Wordpress, how to install, how to transfer, and how to import a blog from a prior location. A few parting cautions:

If you reboot your machine, services just installed will not restart unless you make them run on startup. This can be done in Webmin in System \> Bootup and Shutdown. Select httpd, mysqld, and webmin, and set them to “Start on Boot”. If you’re troubleshooting, you may or may not want these on, but generally, it’s a good idea.

15. - Create a new sql user and password

/usr/bin/mysqladmin -u root password ‘YOURpass\_word’

Create the Wordpress database and dedicated mysql user

mysql -p

mysql\> CREATE DATABASE wpdb;

mysql\> GRANT ALL PRIVILEGES ON wpdb.\* TO wpuser@localhost IDENTIFIED BY "another-new-password";

mysql\> FLUSH PRIVILEGES;

mysql\> exit

Add Wordpress to the html folder:

```sh
cd /var/www/html

wget http://wordpress.org/latest.zip

unzip latest.zip

cp -rpf ./wordpress/* .

rm -rf latest.zip

cp wp-config-sample.php wp-config.php

```

Edit wp-config, and set the information accordingly:

define('DB_NAME', 'wpdb');

define('DB_USER', 'wpuser');

define('DB_PASSWORD', 'new-password');



define('AUTH_KEY',         'xxx');

define('SECURE_AUTH_KEY',  'xxx');

define('LOGGED_IN_KEY',    'xxx');

define('NONCE_KEY',        'xxx’);

define('AUTH_SALT',        'xxx');

define('SECURE_AUTH_SALT', 'xxx');

define('LOGGED_IN_SALT',   'xxx');

define('NONCE_SALT',       'xxx');



$table_prefix  = 'wp_';

You can use <https://api.wordpress.org/secret-key/1.1/salt/> to generate unique digits

```sh
Cd ~/

Cd /var/www

Chmod -R 644 html

```

Import

Rebuild permalinks if you import database directly

\# Added based on site - <http://dumpk.com/2013/09/17/mysql-crash-problems-on-ec2-aws/>

```sh
innodb_buffer_pool_size = 40M
key_buffer_size=10M
max_connections=5
```
