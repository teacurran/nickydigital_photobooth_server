NickyDigital Photobooth Server App
==================================


Installation
============

OSX
------------------------------
Windows
------------------------------

1. install Github: http://github.com

2. install MAMP

3. Use github to clone the repository, somewhere like: /Users/nicky/Documents/nickydigital_photobooth_server

4. in the terminal type: mysqladmin -u root password root
 
5. in the terminal type: mysql -u root -proot -e "CREATE DATABASE photobooth"

6. cd /Users/nicky/Documents/nickydigital_photobooth_server 

7. ./update.sh

8. restart MAMP




Windows
------------------------------

1. install the latest distribution of MsysGit: https://code.google.com/p/msysgit/downloads/list
2. install Github: http://windows.github.com
3. install WampServer, 32bit: http://www.wampserver.com
4. Use github to clone the repository, somewhere like: C:\Users\nicky\Docuents\nickydigital_photobooth_server
5. Add PHP and mySQL bin paths to the system PATH environment variable. 

Control Panel > System and Security > System > Advanced System Settings > Environment Variables 

Bin folders are in: C:\wamp\bin\php\php5.3.13 and c:\wamp\bin\mysql\mysql5.5.24 

6. Use the wamp task bar panel to enable the following php extensions: php_curl, php_fileinfo, php_phar

7. Use the wamp task bar panel to enable the following apache extensions: mod_rewrite

8. from the command prompt: c:\wamp\mysql\mysql5.5.24\bin\mysqladmin -u root password root
 
9. from the command prompt: c:\wamp\mysql\mysql5.5.24\bin\mysql -u root -proot -e "CREATE DATABASE photobooth"

10. run update.sh

11. restart wamp






 


