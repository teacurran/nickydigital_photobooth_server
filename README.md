NickyDigital Photobooth Server App
==================================


Installation
============

OSX
------------------------------

1. set your OSX security proferences to allow software from unidentified developers

2. install Github: http://github.com : make sure you also install the command line tools

3. install git: http://git-scm.com/downloads

4. install MAMP

5. vim ~/.profile

6. Add the line at the bottom:
export PATH=/Applications/MAMP/Library/bin:$PATH

7. sudo cp /etc/php.ini.default /etc/php.ini

8. sudo vim /etc/php.ini

9. find the default timezone line and change it to:
date.timezone=America/New_York

7. close the terminal window and open a new one

8. Use github to clone the repository, somewhere like: /Users/nicky/nickydigital_photobooth_server

9. in the terminal type: mysql -u root -proot -e "CREATE DATABASE photobooth"

10. cd /Users/nicky/nickydigital_photobooth_server/web
note that "web" is added to this URL 

11. ./update.sh

12. In MAMP, change Preferences > Apache > Document Root to: /Users/nicky/nickydigital_photobooth_server

13. In MAMP, click Prefernces > Ports, click "Set to default Apache and MySQL ports

14. restart MAMP




Windows
------------------------------

1. install the latest distribution of MsysGit: https://code.google.com/p/msysgit/downloads/list
2. install Github: http://windows.github.com
3. install WampServer, 32bit: http://www.wampserver.com
4. Use github to clone the repository, somewhere like: C:\Users\nicky\Docuents\nickydigital_photobooth_server
5. Add PHP and mySQL bin paths to the system PATH environment variable. 

Control Panel > System and Security > System > Advanced System Settings > Environment Variables 

Bin folders are: C:\wamp\bin\php\php5.4.16 and c:\wamp\bin\mysql\mysql5.6.12\bin

6. Use the wamp task bar panel to enable the following php extensions: php_curl, php_fileinfo, php_openssl
    You may have to edit php.ini in C:\wamp\bin\php\php5.4.16 to remove the ; from in front of these extensions

7. Use the wamp task bar panel to enable the following apache extensions: mod_rewrite

8. from the command prompt: c:\wamp\mysql\mysql5.6.12\bin\mysqladmin -u root password root
 
9. from the command prompt: c:\wamp\mysql\mysql5.6.12\bin\mysql -u root -proot -e "CREATE DATABASE photobooth"

10. run update.sh

11. restart wamp


Code Examples
===================================================

Generate a enw admin page
s2 admin:generate-admin --model-name=User --namespace=NickyDigital\PhotoboothBundle --bundle-name=PhotoboothBundle --dir=./src


 


