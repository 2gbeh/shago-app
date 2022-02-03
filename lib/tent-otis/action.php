<?PHP
// START SESSION
session_start();

// SUPRERSS ERROR
error_reporting(E_ALL ^ E_DEPRECATED);
set_error_handler (function(){});

// NO CACHE
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// EXTEND VAR_DUMP
ini_set('xdebug.var_display_max_children',-1);
ini_set('xdebug.var_display_max_data',-1);
ini_set('xdebug.var_display_max_depth',-1);

// JSON HEADER
header('Content-Type: application/json; charset=UTF-8');
include_once 'model.php';

$ignore = array('::1','127.0.0.1','102.89.1.207','129.205.112.152');
$otis = new tent_otis_bean('data.json');
if (isset($_GET['tent_otis_set']))
{
	if (!in_array($otis->proxy(),$ignore))
	{
		if ($otis->exist())
			$otis->update();
		else
			$otis->insert();
	}
		
	$res['size'] = $otis->get_size();		
	$res['row'] = $otis->get_row();	
	$res['id'] = $otis->get_id();	
}
else if (isset($_GET['tent_otis_get']))
{
	$res = array(
		'size' => $otis->get_size(),
		'rows' => $otis->get_data(), 
		'meta' => $otis->report()
	);
}
else
{
	$res = $otis->get_data();
}
$otis->publish($res);
?>


