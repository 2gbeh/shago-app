<?PHP
# CONSTANTS
define('VAT', 			'0.75');
define('SHIPPING', 	array(550,1050));
define('DISCOUNT', 	'0');

# LISTS
$list_cat = array
(
	array('fabrics_textiles', 'fas fa-chess-board', 'Fabrics & Textiles'),
	array('fashion', 'fas fa-tshirt', 'Fashion'),
	array('skin_care', 'fas fa-spa', 'Skin Care'),
		
	array('phones_tablets', 'fas fa-mobile-alt', 'Phones & Tablets'),
	array('computers', 'fa fa-desktop', 'Computers'),	
	array('electronics', 'fa fa-tv', 'Electronics'),
	
	array('car_parts', 'fa fa-car', 'Car Parts'),	
	array('furniture', 'fas fa-couch', 'Furniture'),
	array('sports', 'fas fa-basketball-ball', 'Sports'),

	array('food_stuffs', 'fas fa-hamburger', 'Food Stuffs'),	
	array('kitchen_utensils', 'fas fa-mortar-pestle', 'Kitchen Utensils'),	
	array('baby_products', 'fas fa-baby', 'Baby Products'),	
	
	array('building_parts', 'fas fa-paint-roller', 'Building Parts'),
	array('stationeries', 'fa fa-paperclip', 'Stationeries'),
	array('services', 'far fa-handshake', 'Services'),		
);

# STRINGS

# METHODS
function nopage ($page_name)
{
  $buf = '<h1>'.$page_name.'</h1>
    <h2>Woops, <span>Page Not Found!</span></h2>
    <article>
      It appears the requested <b>URL is broken</b> or it\'s original <b>content has been moved</b> 
      to a different location on the server.
    </article>
    <a href="index.php">Return to Homepage</a>';
	return $buf;
}

# CLASS
class Caption
{
	public $title, $sub;
	public function __construct () 
	{
		$pg = basename($_SERVER['PHP_SELF']);
		$buf = '';
		
		if ($pg == 'sign_up.php') {
			$this->title = 'Kirkirar asusunka';			
			$this->subtit = 'create an account';
		}
		if ($pg == 'sign_in.php') {
			$this->title = 'Shiga cikin asusun';	
			$this->subtit = 'login to your account';		
		}
		if ($pg == 'sign_in_help.php') {
			$this->title = 'Kirkirar asusunka';
			$this->subtit = 'recover your password';				
		}
		if ($pg == 'ticket.php') {
			$this->title = 'Customer ra\'ayi';
			$this->subtit = 'customer feedback';		
		}
	}
}
$new_caption = new Caption();

?>

