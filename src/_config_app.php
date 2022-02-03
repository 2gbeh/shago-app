<?PHP
// CONSTANTS
define('TYPE', 			'eCommerce Website');
define('APPNAME', 	'ShagoApp');
define('ALIAS', 		'Shagoapp.com');
define('CAPTION', 	'KANO State Let\'s Go!');
define('COMPANY', 	'Shago, Inc.');
define('SUMMARY', 	'Shagoapp.com is an online business directory and e-commerce marketplace for businesses located around Farm Center, Kano State, Nigeria.');
define('KEYWORDS', 	'shago, shago inc, shago app, shopping cart, farm center, kano state, hwp labs, tugbeh emmanuel');
define('COPYRIGHT',	'Copyright &copy; 2020 '.COMPANY);
define('EMAIL',			'saintapict@gmail.com');
define('EMAIL_2',		'tugbeh.osaretin@gmail.com');
define('EMAIL_3',		'osasfrank246@gmail.com');
define('PHONE',			'+2348066311146');
define('PHONE_2',		'+2348169960927');
define('PHONE_3',		'+2349050278809');
define('ADDRESS',		'Shop A2 Farm Center, Tarauni, Kano State, Nigeria.');
define('THEME_PRI',	'#CE1126');
define('THEME_SEC',	'#FCD116');
define('THEME_ALT',	'#2D2D2D');

// APACHE
define('SERVER', 		'shagoapp');
define('DATABASE',	SERVER.'_db');
if ($_SERVER['SERVER_NAME'] == 'localhost') {
	define('USERNAME',	'root');
	define('PASSWORD',	'');
} else {
	define('USERNAME',	SERVER.'_root');
	define('PASSWORD', 	'_Strongp@ssw0rd');
}

// ISP
define('INDEX', 		'index.php');
define('DOMAIN', 		'shagoapp.com');
define('CPANEL', 		'https://'.DOMAIN.'/cpanel');
define('WEBMAIL', 	'https://'.DOMAIN.'/webmail');;
define('WEBMAIL_1',	'info@'.DOMAIN);
define('WEBMAIL_2',	'support@'.DOMAIN);
define('WEBMAIL_3',	'admin@'.DOMAIN);
define('VERSION',		'5.19.6.20');
define('HOSTED',		'2020-06-19');
define('REVISED',		'2022-06-18');

// META TAGS
$m = array();
$m['author'] =					'HWP Labs';
$m['classification'] = 	TYPE;
$m['copyright'] = 			date('Y');
$m['coverage'] = 				'Nigeria';
$m['description'] = 		SUMMARY;
$m['designer'] = 				'Tugbeh, E.O.';
$m['keywords'] = 				KEYWORDS;
$m['language'] = 				'en';
$m['owner'] = 					COMPANY;
$m['reply_to'] = 				WEBMAIL_1;
$m['revised'] = 				REVISED;
$m['robots'] = 					'index,follow';
$m['theme_color'] = 		THEME_PRI;
$m['url'] = 						'https://'.DOMAIN.'/';
$m['viewport'] = 				isset($page_ctx_viewport)? '': 'width=device-width, initial-scale=1.0';
$m['title'] = 					! isset($page_ctx_title)? CAPTION: $page_ctx_title.' - '.ALIAS;
$META = (object)$m;
?>




