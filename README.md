Lindacarlstad.se
================

Repository of Lindacarlstad.se

###When deploying dont forget:
- rename application/config/_database.php to application/config/database.php and add credentials
- rename modules/paypal/classes/_config.php to modules/paypal/classes/config.php and add credentials
- Add paypal certificate into modules/paypal/classes/
- Make sure these folders have writeaccess:
	- upload/, images/users, images/shop, files/, application/logs/, application/cache