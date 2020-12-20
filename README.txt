# EntertainmentWebsite
Project website

Setting up the Project
1. Move the EntertainmentWebsite folder to C:/wamp64/www
2. On the hosts file enter: <ip address> bighitmusic.com
3. On the httpd-vhosts.conf file on wamp, copy and paste the following:

#bighitmusic
<VirtualHost *:80>
  ServerName bighitmusic
  ServerAlias bighitmusic.com
  DocumentRoot "${INSTALL_DIR}/www/EntertainmentWebsite/src"
  <Directory "${INSTALL_DIR}/www">
    Options +Indexes +Includes +FollowSymLinks +MultiViews
    AllowOverride All
    Require local
  </Directory>
</VirtualHost>

4. Refresh the DNS of the wamp server
5. Import the Alpha Group.sql into pypmyadmin into a database named "bighitent"
	5.1 Make sure that the port where the database is saved is the same 
	    as the port listed under app.js line 13 (EntertainmentWebsite/src), 
	    as well as in the database.php line 2 in the admin module 
	    (EntertainmentWebsite/src/includes).

6. To run the public site module, run the following command "node app" using 
   a terminal under the directory "EntertainmentWebsite/src"
	6.1 For the client side, just enter the following link: bighitmusic.com:8001
	6.2 To make sure that the playlist is working, search "Blue Hour" and play
	    the album under the music page.
	    
7. For the admin side, use the following link: bighitmusic.com/admin 
	7.1 Use the following credentials for the log-in page: 
		Username: Kilrone
		Password: Kilrone


