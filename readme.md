# NSFWshow's Viral Video Hall Of Fame

1. Clone to whereever you like working from
2. Set up a vhost entry in apache (unless files are in root of webserver)
    For example in the apache/conf/extra/httpd-vhosts.conf file (based on xampp):
    ```
	NameVirtualHost *:80 ## UNCOMMENT THIS LINE
	
    <VirtualHost *:80>
		DocumentRoot "C:/xampp/htdocs"
		ServerName localhost
	</VirtualHost>
	
	<VirtualHost *:80>
		DocumentRoot "C:/xampp/htdocs/halloffame/public"
		ServerName halloffame.dev
	</VirtualHost>
    ```
3. Make config files to `application/config/local/` based on `application/config/` (remember what was mentioned in the laravel installation docs here, if your copy isn't hosted on *.dev address or localhost, add yourself in `/paths.php`)
    1. application.php - Overwrite url, key
    2. database.php - Database settings
    3. twitter.php - Twitter settings
4. Install database to keep track of migrations: `php artisan migrate:install --env=local`
5. `php artisan migrate --env=local`
6. ???
7. Profit!