<?PHP
# ERROR
class Notice
{
	public static function main ($error, $errno = 400) 
	{
		if (isset($_GET['err'])) {
			$error = $_GET['err'];
			$errno = 300;
		}
				
		switch ($errno) {
			case 100:
				$entity = '&#9855;'; // accessibility
				$color = 'notice_attention'; // @continue
				break;
			case 200:
				$entity = '&#9989;'; // grren heavy check mark
				$color = 'notice_success'; // OK
				break;
			case 300:
				$entity = '&#128276;'; // bell &#128276;  bold &#9889;
				$color = 'notice_warning'; // ?multiple choices
				break;
			default:
				$entity = '&#9940;'; // no entry
				$color = 'notice_danger'; // !bad request
		}
		
		if (isset($error) && isset($errno)) {
			return '<div class="notice '.$color.'" id="notice" style="display:block;">
				<i onClick="document.getElementById(\'notice\').style.display=\'none\'" title="Close">&times;</i>
				<var>'.$entity .' &nbsp; '. $error.'</var>
			</div>';
		}
	}	
}

# PAGE CONTEXT
class Context
{
	public static $ctx = array();	
	public static function set ($title, $file, $lock = NULL, $viewport = NULL)
	{	
		$arr = array();
		$arr['page_ctx_title'] = $title;		
		$arr['page_ctx_file'] = $file;
		$arr['page_ctx_name'] = str_replace('.php','',$file);
		$arr['page_ctx_action'] = 'action_'.$file;
		$arr['page_ctx_lock'] = $lock;			
		$arr['page_ctx_viewport'] = $viewport;
		
		self::$ctx[$file] = $arr;
	}
	public static function get ($file = NULL)
	{
		$key = is_null($file)? basename($_SERVER['PHP_SELF']): $file;
		return self::$ctx[$key];
	}	
	public static function map ($file = NULL)
	{
		return self::$ctx;
	}
}

# ENUMERATED TYPES
class Enums
{
	public static function is_key ($enums, $e)
	{
		$e = strtolower($e);
		$new = array_map('strtolower',array_keys($enums));
		return in_array($e,$new);
	}
	public static function is_value ($enums, $e)
	{
		$e = strtolower($e);
		$new = array_map('strtolower',$enums);
		return in_array($e,$new);
	}
	public static function translate ($enums, $e)
	{
		if (self::is_key($enums,$e)) 
			return $enums[$e];
		if (self::is_value($enums,$e)) 
			return array_search($e,$enums);
	}
	public static function datalist ($enums, $id)
	{
		$buffer = '';
		foreach ($enums as $value)
			$buffer .= '<option value="'.$value.'" />';
		return '<datalist id="'.$id.'">'.$buffer.'</datalist>';
	}		
	public static function option ($enums, $selected = NULL)
	{
		$buffer = '';
		foreach ($enums as $key => $value)
		{
			if (!is_null($value))
			{
				if ($selected == $key)
					$buffer .= '<option value="'.$key.'" selected>'.$value.'</option>';
				else
					$buffer .= '<option value="'.$key.'">'.$value.'</option>';
			}
		}
		return $buffer;
	}
}

# PAGINATION
class Pager
{	
	// NOTE NO NEED FOR CLAUSE AND NAV IF SIZE IS LESS THAN LIMIT
	public $n, $lmt, $of, $id, $off, $from, $to, $clause, $caption, $nav;  
	public function __construct ($n, $lmt = 25) 
	{
		if ($n > $lmt)
		{
			$this->n = $n;
			$this->lmt = $lmt;	
			$this->of = $of = ceil($n / $lmt);		
			
			if ($_GET['p'] == true) {
				$id = (int) $_GET['id'];
				switch ($_GET['q']) {
					case 'f':
						$id = 1; break;
					case 'p':
						$id -= 1; break;
					case 'n':
						$id += 1; break;				
					case 'l':
						$id = $of; break;
					default:
						$id = (int) $_GET['q'];
				}		
				if ($id < 1) $id = 1;
				if ($id > $of) $id = $of;			
			}
			else
				$id = 1;
			
			$this->id = $id;		
			$this->off = $off = ($id * $lmt) - $lmt;
			$this->from = $from = $off + 1;
			$this->to = $to = ($from + $lmt) - 1;
			if ($to > $n) $this->to = $to = $n;
			$this->clause = $clause = 'LIMIT '.$lmt.' OFFSET '.$off;
			$this->caption = $caption = 'Showing '.$from.' to '.$to.' of '.$n.' records'; 
				
			$this->nav = $nav = '<table class="pager" border="0">
				<caption align="bottom">'.$caption.'</caption>
				<tr>
					<th title="First" onClick="onPager(\'f\')">&laquo;</th>
					<th title="Previous" onClick="onPager(\'p\')">&lsaquo;</th>
					<td title="Page"><input type="text" id="pager_id" value="'.$id.'" maxlength="2" readonly /></td>
					<td title="Total"><label>of '.$of.'</label></td>
					<th title="Next" onClick="onPager(\'n\')">&rsaquo;</a></th>
					<th title="Last" onClick="onPager(\'l\')">&raquo;</th>
				</tr>
			</table>';
		}
	}
}

# ANNUAL MAINTENANCE
class Anum
{
	public static $hosted, $color,
		$expires, $expires_f, $expires_b, 
		$days_used, $days_left, $perc_used, $perc_left;
	public static function main ($hosted) 
	{
		$h = explode('-', $hosted);
		$from = mktime(0,0,0, $h[1], $h[2], $h[0]);
		$to = strtotime('+365 days', $from);		 
		self::$hosted = $hosted;
		self::$expires = $expires = date('Y-m-d', $to);
		self::$expires_f = $expires_f = date('d/m/Y', $to);
		self::$expires_b = $expires_b = date('w.d.m.y', $to);		
		
		$d1 = date_create($hosted);
		$d2 = date_create(date());
		$diff = date_diff($d1, $d2);
		self::$days_used = $days_used = $diff->days;
		self::$days_left = $days_left = 365 - $days_used;
		
		
		self::$perc_used = $perc_used = floor(($days_used * 100) / 365);
		self::$perc_left = $perc_left = 100 - $perc_used;
		
		if ($perc_used <= 33) 
			self::$color = '#00A65A';
		else if ($perc_used > 33 && $perc_used <= 66) 
			self::$color = '#F39C12';
		else 
			self::$color = '#DD4B39';
	}
	public static function elapsed() 
	{		
		return self::$days_left < 0;
	}
	public static function meter() 
	{	
		return '<div class="anum">
			<div>
				Annual Maintenance: <b>'.self::$expires_f.'</b> 
				<a title="Contact +234(0) 81 6996 0927" onclick=anumInfo('.json_encode(self::map()).')>&#9432;</a>
			</div>
			<ol title="'.self::$days_left.' day(s) left">
				<li style="background-color:'.self::$color.'; width:'.self::$perc_used.'%;"></li>
			</ol>
		</div>';
	}
	public static function scanner() 
	{
		$list = file_crawl();
		return '<div class="anum_scanner" id="anum_scanner">
			<label for="file">New License:</label>
			<input type="file" name="file" list="'.implode(',',$list).'" accept="text/plain" onchange="anumScanner()" required />
			<section>
				<progress value="0" max="100"></progress>
				<output></output>
				<button></button>
			</section>
		</div>';
	}
	public static function upload ($dir = 'src/') 
	{
		if (strlen($_FILES['file']['name']) > 0) {		
			$content = read_file($_FILES['file']['tmp_name']);
			return create_file($dir . '_config_app.php', $content);
		}
	}	
	public static function map () 
	{
		return array (
			self::$hosted,
			self::$color,
			self::$expires,
			self::$expires_f,
			self::$expires_b,
			self::$days_used,
			self::$days_left,
			self::$perc_used,
			self::$perc_left,
		);
	}	
}

# GOOGLE TRANSLATE
class Translate
{
	// ADD THIS <div id="google_translate_element" style="float:right;"></div>
	const CDN = '<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>';

	public static function SIMPLE() 
	{
		return '<script type="text/javascript">
			function googleTranslateElementInit() 
			{
				new google.translate.TranslateElement ({
						pageLanguage: "en", 
						layout: google.translate.TranslateElement.InlineLayout.SIMPLE
					}, "google_translate_element"
				);
			}
		</script>'."\r\n".self::CDN;
	}		
	public static function HORIZONTAL() 
	{
		return '<script type="text/javascript">
			function googleTranslateElementInit() 
			{
				new google.translate.TranslateElement ({
						pageLanguage: "en", 
						layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL
					}, "google_translate_element"
				);
			}
		</script>'."\r\n".self::CDN;
	}	
	public static function CLASSIC() 
	{
		return '<script type="text/javascript">
			function googleTranslateElementInit() 
			{
				new google.translate.TranslateElement ({
						pageLanguage: "en"
					}, "google_translate_element"
				);
			}
		</script>'."\r\n".self::CDN;
	}	
}

# ENUMERATED TYPES EXTENDED
class Lists extends Enums
{
	const 
		BOOL = array (NULL,'Yes','No'),	
		ACTION = array (NULL,'INSERT','SELECT','UPDATE','DELETE'),
		ADMIN = array (NULL,'Editor','Administrator','Super Admin','Webmaster','Architect'),
		USER = array (NULL,'Default User','Verified User','Subscribed User','Super User','Deactivated'),
		TITLE = array (NULL,'Dr.','Esq.','Hon.','Jr.','Mr.','Mrs.','Ms.','Msgr.','Prof.','Rev.','Sr.','St.'),
		GENDER = array (NULL,'M'=>'Male','F'=>'Female'),
		MARITAL = array(NULL,'Single','Married','Separated','Divorced','Widowed'),
		RELIGION = array(NULL,'Christianity','Islam','Hinduism','Buddhism','Sikhism','Taoism','Judaism','Confucianism','Bahá\'í','Shinto','Jainism','Zoroastrianism','Others'),
		RACE = array(NULL,'White/Caucasian','Mongoloid/Asian','Negroid/Black','Australoid'),		
		CONTINENT = array(NULL,'Africa', 'North/South America','Antarctica','Asia','Australia','Europe','Oceania'),
		CHANNEL = array(NULL,'ATM/Quick Teller','Bank Transfer','Cash Deposit','Internet Banking','Mobile Transfer','Point-Of-Sale (POS)','SMS/USSD Code'),
		ERROR = array(NULL,100=>'ATTENTION',200=>'SUCCESS',300=>'WARNING',400=>'DANGER'),
		DAY_SHORT = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat'),		
		DAY = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'),	
		MONTH_SHORT = array(NULL,'Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'),
		MONTH = array(NULL,'January','February','March','April','May','June','July','August','September','October','November','December'),
		COLOR = array(NULL,'red','pink','purple','indigo','light blue','cyan','green','light green','amber','orange','deep orange'),		
		HEXCODE = array(NULL,'#F44336','#E91E63','#9C27B0','#3F51B5','#03A9F4','#00BCD4','#4CAF50','#8BC34A','#FFC107','#FF9800','#FF5722'),
		DELIVERY = array(NULL,'Home Delivery','Pickup Station'),
		PAYMENT = array(NULL,'Pay on Delivery','Pay Online'),
		ORDER = array(NULL,'Cancelled','Confirmed','Packaged','Enroute','Arrived','Delivered');
		
	const	AGE_GROUP = array(
		NULL,		
		'0 – 12  (Adolescent)',
		'13 – 18  (Teenager)',
		'19 – 44  (Adult)',
		'45 – 64  (Senior)',
		'65 – above  (Elder)'
	);
	
	const	VALID_ID = array(
		NULL,
		'Affidavit / Age Declaration',
		'Birth Certificate',
		'Driver\'s License',
		'HMO/Hospital Card',
		'Int\'l Passport',
		'National ID Card',
		'Staff / Student ID Card',
		'Utility Bill',
		'Voter\'s Card',
		'Resident / Work Permit'
	);
	
	const STATE = array(
		NULL,
		'Abia','Abuja','Adamawa','Akwa Ibom','Anambra',
		'Bauchi','Bayelsa','Benue','Borno',
		'Cross River',
		'Delta',
		'Ebonyi','Edo','Ekiti','Enugu',
		'Gombe',
		'Imo',
		'Jigawa',
		'Kaduna','Kano','Katsina','Kebbi','Kogi','Kwara',
		'Lagos',
		'Nasarawa',	'Niger',
		'Ogun','Ondo','Osun','Oyo',
		'Plateau',
		'Rivers',
		'Sokoto',
		'Taraba',
		'Yobe',
		'Zamfara');
	
	const BANK = array(
		NULL,
		'Access Bank',
		'Citi Bank',
		'Diamond Bank (Access)',
		'Ecobank','FCMB',
		'Fidelity Bank','FirstBank',
		'GTBank',
		'Heritage Bank',
		'Jaiz Bank','Jubilee Bank',
		'Keystone Bank',
		'Mainstreet Bank',
		'Skye Bank (Polaris)','Stanbic IBTC','Standard Chartered Bank','Sterling Bank','Suntrust Bank',
		'UBA','Union Bank','Unity Bank',
		'WEMA Bank',
		'Zenith Bank');
	
	const DEGREE = array(
		NULL,
		'WASSCE' => 'West African Secondary School Certificate Examination',
		'GCE ' => 'General Certificate of Education',
		'OND' => 'Ordinary National Diploma',
		'NHD' => 'Higher National Diploma',
		'LLB' => 'Bachelor of Law',
		'B.Sc' => 'Bachelor of Science',
		'PGD' => 'Post Graduate Diploma',
		'PGDE' => 'Post Graduate Diploma in Education',
		'M.Sc' => 'Master of Science',
		'Ph.D' => 'Doctor of Philosophy'
	);
	
	const SECTOR = array(
		NULL,	
		'Academics / Education / Examination',
		'Accounting',
		'Advertising & PR',
		'Aerospace',
		'Agriculture / Farming',
		'Archaeology / Museum',
		'Architecture',
		'Assets & Property Management',
		'Assurance / Insurance',
		'Automobile',
		'Banking & Finance',
		'Beverages / Brewery',
		'Broadcast / Press Media',
		'Building and Construction',
		'Business Administration / Management',
		'Career & Talent Management',
		'Charity & NGO',
		'Civil / Public Services',
		'Computer Hardware',
		'Consultancy / Specialist',
		'Consumer Service',
		'Cosmetics / Skin Care',
		'Creative Arts & Design',
		'Crystals / Jewels',
		'Currency / Foreign Exchange',
		'Customer Service',
		'Customs & Immigration',
		'Drugs / Pharmaceuticals',
		'Electricals & Electronics',
		'Energy / Power',
		'Engineering',
		'Entertainment',
		'Environment / Geography',
		'Event Planning & Management',
		'Fabrics / Leather / Textiles',
		'Fashion',
		'Food / Herbs',
		'HR / Recruitment',
		'Health & Safety (HSE)',
		'Health / Healthcare / HMO',
		'Hospitality',
		'Information Technology',
		'Internet / Social Media',
		'Labor / Labour',
		'Laboratory Service and Equipment',
		'Law / Legal',
		'Law Enforcement',
		'Literature / Publication',
		'Manufacturing / Production',
		'Marketing and Sales',
		'Martials Arts / Yoga',
		'Minerals / Mining',
		'Multimedia',
		'Networking / Telecommunications',
		'Oil and Gas',
		'Photography / Videography',
		'Printing Press',
		'Real Estate',
		'Science and Technology',
		'Security',
		'Sports and Recreation',
		'Supply Chain and Procurement',
		'Tax & Audit',
		'Teaching / Training',
		'Transport and Logistics',
		'Travel and Tourism',
		'Utilities',
		'Vocational Trade & Services',
		'Wellness & Fitness',
		'Wholesale / Retail',
		'Others'
	);
	
	const COUNTRY = array(
		NULL,
		'AFG' => 'Afghanistan', 
		'ALA' => 'Åland Islands', 
		'ALB' => 'Albania', 
		'DZA' => 'Algeria', 
		'ASM' => 'American Samoa', 
		'AND' => 'Andorra', 
		'AGO' => 'Angola', 
		'AIA' => 'Anguilla', 
		'ATA' => 'Antarctica', 
		'ATG' => 'Antigua and Barbuda', 
		'ARG' => 'Argentina', 
		'ARM' => 'Armenia', 
		'ABW' => 'Aruba', 
		'AUS' => 'Australia', 
		'AUT' => 'Austria', 
		'AZE' => 'Azerbaijan', 
		'BHS' => 'Bahamas', 
		'BHR' => 'Bahrain', 
		'BGD' => 'Bangladesh', 

		'BRB' => 'Barbados', 
		'BLR' => 'Belarus', 
		'BEL' => 'Belgium', 
		'BLZ' => 'Belize', 
		'BEN' => 'Benin', 
		'BMU' => 'Bermuda', 
		'BTN' => 'Bhutan', 
		'BOL' => 'Bolivia, Plurinational State of..', 
		'BES' => 'Bonaire, Sint Eustatius and Saba', 
		'BIH' => 'Bosnia and Herzegovina', 
		'BWA' => 'Botswana', 
		'BVT' => 'Bouvet Island', 
		'BRA' => 'Brazil', 
		'IOT' => 'British Indian Ocean Territory', 
		'BRN' => 'Brunei Darussalam', 
		'BGR' => 'Bulgaria', 
		'BFA' => 'Burkina Faso', 
		'BDI' => 'Burundi', 
		'KHM' => 'Cambodia', 
		'CMR' => 'Cameroon', 
		'CAN' => 'Canada', 
		'CPV' => 'Cape Verde', 
		'CYM' => 'Cayman Islands', 
		'CAF' => 'Central African Republic', 
		'TCD' => 'Chad', 
		'CHL' => 'Chile', 
		'CHN' => 'China', 
		'CXR' => 'Christmas Island', 
		'CCK' => 'Cocos (Keeling) Islands', 
		'COL' => 'Colombia', 
		'COM' => 'Comoros', 
		'COG' => 'Congo', 
		'COD' => 'Congo, the Democratic Republic of the', 
		'COK' => 'Cook Islands', 
		'CRI' => 'Costa Rica', 
		'CIV' => 'Côte d\'Ivoire', 
		'HRV' => 'Croatia', 
		'CUB' => 'Cuba', 
		'CUW' => 'Curaçao', 
		'CYP' => 'Cyprus', 
		'CZE' => 'Czech Republic', 
		'DNK' => 'Denmark', 
		'DJI' => 'Djibouti', 
		'DMA' => 'Dominica', 
		'DOM' => 'Dominican Republic', 
		'ECU' => 'Ecuador', 
		'EGY' => 'Egypt', 
		'SLV' => 'El Salvador', 
		'GNQ' => 'Equatorial Guinea', 
		'ERI' => 'Eritrea', 
		'EST' => 'Estonia', 
		'ETH' => 'Ethiopia', 
		'FLK' => 'Falkland Islands (Malvinas)', 
		'FRO' => 'Faroe Islands', 
		'FJI' => 'Fiji', 
		'FIN' => 'Finland', 
		'FRA' => 'France', 
		'GUF' => 'French Guiana', 
		'PYF' => 'French Polynesia', 
		'ATF' => 'French Southern Territories', 
		'GAB' => 'Gabon', 
		'GMB' => 'Gambia', 
		'GEO' => 'Georgia', 
		'DEU' => 'Germany', 
		'GHA' => 'Ghana', 
		'GIB' => 'Gibraltar', 
		'GRC' => 'Greece', 
		'GRL' => 'Greenland', 
		'GRD' => 'Grenada', 
		'GLP' => 'Guadeloupe', 
		'GUM' => 'Guam', 
		'GTM' => 'Guatemala', 
		'GGY' => 'Guernsey', 
		'GIN' => 'Guinea', 
		'GNB' => 'Guinea-Bissau', 
		'GUY' => 'Guyana', 
		'HTI' => 'Haiti', 
		'HMD' => 'Heard Island and McDonald Islands', 
		'VAT' => 'Holy See (Vatican City State)', 
		'HND' => 'Honduras', 
		'HKG' => 'Hong Kong', 
		'HUN' => 'Hungary', 
		'ISL' => 'Iceland', 
		'IND' => 'India', 
		'IDN' => 'Indonesia', 
		'IRN' => 'Iran, Islamic Republic of..', 
		'IRQ' => 'Iraq', 
		'IRL' => 'Ireland', 
		'IMN' => 'Isle of Man', 
		'ISR' => 'Israel', 
		'ITA' => 'Italy', 
		'JAM' => 'Jamaica', 
		'JPN' => 'Japan', 
		'JEY' => 'Jersey', 
		'JOR' => 'Jordan', 
		'KAZ' => 'Kazakhstan', 
		'KEN' => 'Kenya', 
		'KIR' => 'Kiribati', 
		'PRK' => 'Korea, Democratic People\'s Republic of..', 
		'KOR' => 'Korea, Republic of..', 
		'KWT' => 'Kuwait', 
		'KGZ' => 'Kyrgyzstan', 
		'LAO' => 'Lao People\'s Democratic Republic', 
		'LVA' => 'Latvia', 
		'LBN' => 'Lebanon', 
		'LSO' => 'Lesotho', 
		'LBR' => 'Liberia', 
		'LBY' => 'Libya', 
		'LIE' => 'Liechtenstein', 
		'LTU' => 'Lithuania', 
		'LUX' => 'Luxembourg', 
		'MAC' => 'Macao', 
		'MKD' => 'Macedonia, the former Yugoslav Republic of..', 
		'MDG' => 'Madagascar', 
		'MWI' => 'Malawi', 
		'MYS' => 'Malaysia', 
		'MDV' => 'Maldives', 
		'MLI' => 'Mali', 
		'MLT' => 'Malta', 
		'MHL' => 'Marshall Islands', 
		'MTQ' => 'Martinique', 
		'MRT' => 'Mauritania', 
		'MUS' => 'Mauritius', 
		'MYT' => 'Mayotte', 
		'MEX' => 'Mexico', 
		'FSM' => 'Micronesia, Federated States of..', 
		'MDA' => 'Moldova, Republic of..', 
		'MCO' => 'Monaco', 
		'MNG' => 'Mongolia', 
		'MNE' => 'Montenegro', 
		'MSR' => 'Montserrat', 
		'MAR' => 'Morocco', 
		'MOZ' => 'Mozambique', 
		'MMR' => 'Myanmar', 
		'NAM' => 'Namibia', 
		'NRU' => 'Nauru', 
		'NPL' => 'Nepal', 
		'NLD' => 'Netherlands', 
		'NCL' => 'New Caledonia', 
		'NZL' => 'New Zealand', 
		'NIC' => 'Nicaragua', 
		'NER' => 'Niger', 
		'NGA' => 'Nigeria', 
		'NIU' => 'Niue', 
		'NFK' => 'Norfolk Island', 
		'MNP' => 'Northern Mariana Islands', 
		'NOR' => 'Norway', 
		'OMN' => 'Oman', 
		'PAK' => 'Pakistan', 
		'PLW' => 'Palau', 
		'PSE' => 'Palestinian Territory, Occupied', 
		'PAN' => 'Panama', 
		'PNG' => 'Papua New Guinea', 
		'PRY' => 'Paraguay', 
		'PER' => 'Peru', 
		'PHL' => 'Philippines', 
		'PCN' => 'Pitcairn', 
		'POL' => 'Poland', 
		'PRT' => 'Portugal', 
		'PRI' => 'Puerto Rico', 
		'QAT' => 'Qatar', 
		'REU' => 'Réunion', 
		'ROU' => 'Romania', 
		'RUS' => 'Russian Federation', 
		'RWA' => 'Rwanda', 
		'BLM' => 'Saint Barthélemy', 
		'SHN' => 'Saint Helena, Ascension and Tristan da Cunha', 
		'KNA' => 'Saint Kitts and Nevis', 
		'LCA' => 'Saint Lucia', 
		'MAF' => 'Saint Martin (French part)', 
		'SPM' => 'Saint Pierre and Miquelon', 
		'VCT' => 'Saint Vincent and the Grenadines', 
		'WSM' => 'Samoa', 
		'SMR' => 'San Marino', 
		'STP' => 'Sao Tome and Principe', 
		'SAU' => 'Saudi Arabia', 
		'SEN' => 'Senegal', 
		'SRB' => 'Serbia', 
		'SYC' => 'Seychelles', 
		'SLE' => 'Sierra Leone', 
		'SGP' => 'Singapore', 
		'SXM' => 'Sint Maarten (Dutch part)', 
		'SVK' => 'Slovakia', 
		'SVN' => 'Slovenia', 
		'SLB' => 'Solomon Islands', 
		'SOM' => 'Somalia', 
		'ZAF' => 'South Africa', 
		'SGS' => 'South Georgia and the South Sandwich Islands', 
		'SSD' => 'South Sudan', 
		'ESP' => 'Spain', 
		'LKA' => 'Sri Lanka', 
		'SDN' => 'Sudan', 
		'SUR' => 'Suriname', 
		'SJM' => 'Svalbard and Jan Mayen', 
		'SWZ' => 'Swaziland', 
		'SWE' => 'Sweden', 
		'CHE' => 'Switzerland', 
		'SYR' => 'Syrian Arab Republic', 
		'TWN' => 'Taiwan, Province of China', 
		'TJK' => 'Tajikistan', 
		'TZA' => 'Tanzania, United Republic of..', 
		'THA' => 'Thailand', 
		'TLS' => 'Timor-Leste', 
		'TGO' => 'Togo', 
		'TKL' => 'Tokelau', 
		'TON' => 'Tonga', 
		'TTO' => 'Trinidad and Tobago', 
		'TUN' => 'Tunisia', 
		'TUR' => 'Turkey', 
		'TKM' => 'Turkmenistan', 
		'TCA' => 'Turks and Caicos Islands', 
		'TUV' => 'Tuvalu', 
		'UGA' => 'Uganda', 
		'UKR' => 'Ukraine', 
		'ARE' => 'United Arab Emirates', 
		'GBR' => 'United Kingdom', 
		'USA' => 'United States', 
		'UMI' => 'United States Minor Outlying Islands', 
		'URY' => 'Uruguay', 
		'UZB' => 'Uzbekistan', 
		'VUT' => 'Vanuatu', 
		'VEN' => 'Venezuela, Bolivarian Republic of..', 
		'VNM' => 'Viet Nam', 
		'VGB' => 'Virgin Islands, British', 
		'VIR' => 'Virgin Islands, U.S.', 
		'WLF' => 'Wallis and Futuna', 
		'ESH' => 'Western Sahara', 
		'YEM' => 'Yemen', 
		'ZMB' => 'Zambia', 
		'ZWE' => 'Zimbabwe'
	);
}

?>

