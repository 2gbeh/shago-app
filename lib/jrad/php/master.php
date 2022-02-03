<?PHP
# STOP WARNING ERRORS
error_reporting(E_ALL ^ E_DEPRECATED);
set_error_handler (function(){});

# STOP CACHE MEMORY
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

# EXTEND VAR_DUMP
ini_set('xdebug.var_display_max_children',-1);
ini_set('xdebug.var_display_max_data',-1);
ini_set('xdebug.var_display_max_depth',-1);

# FORM ACTION
define('FORM_ATTRIB', 'action="'.htmlspecialchars($_SERVER['PHP_SELF']).'" method="post" autocomplete="on" enctype="multipart/form-data"');
define('FORM_ATTRIB_GET', 'action="'.htmlspecialchars($_SERVER['PHP_SELF']).'" method="get" autocomplete="on"');

# START SESSION
session_start();

# APPSTATE HANDLER
//$appstate = array('index.php');
//$basename = basename($_SERVER['PHP_SELF']);
//if (! in_array($basename,$appstate) && 
//	(
//		substr($basename,0,1) != '_' && 
//		substr($basename,0,1) != '@'
//	)
//)
//{
//	if (! isset($_SESSION['user']))
//		goto_page('index.php?err=Session expired. Log in required.');
//	else
//		$_USER = $_SESSION['user'];		
//}

# LOGOUT HANDLER
if ($_GET['logout'] == true)
{
	session_destroy();
	goto_page('index.php');
}

# VALIDATION SUB-ROUTINE
function sanitize_request ($post_array)
{
	$new_post_array = array();
	foreach ($post_array as $key => $value) 
	{
		if (! is_array($value))
		{
			$value = trim($value);
			$value = stripslashes($value);
			$value = htmlspecialchars($value);
			$new_post_array[$key] = $value;				
		}
	}
	return $new_post_array;
}

function validate_number ($args)
{
	$regex = '/\\d+/';
	return preg_match($regex, $args);
}

function validate_name ($args)
{
	// contains only uppercase and lowercase letter, and whitespaces
	$regex = '/^[a-zA-Z ]*$/';
	return preg_match($regex, $args);
}

function validate_email ($args)
{
	return filter_var($args, FILTER_VALIDATE_EMAIL);
}

function validate_password ($args)
{
	// strong password without special chars
	$regex = '/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&-+=()])(?=\\S+$).{8, 25}$/';
	return preg_match($regex, $args);
}

function validate_url ($args)
{
	$regex = '/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i';
	return preg_match($regex, $args);
}

# DATABASE SUB-ROUTINE
function connect_db ($user, $psw, $db)
{
	$mysqli = new MySQLi('localhost', $user, $psw, $db);
	if ($mysqli->connect_error) 
		die($mysqli->connect_error);
	else
		return $mysqli;
}

function disconnect_db ($mysqli)
{
	$mysqli->close();
}

function sql_insert ($mysqli, $tb, $post_array)
{
	// extract fields
	$keys = array_keys($post_array); 
	$field_set = implode(', ',$keys);
	$values = array_values($post_array); 
	
	// extract values
	$record_set = '';
	foreach ($values as $v)
		$record_set .= '"'.$mysqli->real_escape_string($v).'", ';	
	$record_set = rtrim($record_set,', ');
	
	// execute sql command
	$sql_stmt = 'INSERT INTO `'.$tb.'` ('.$field_set.') VALUES ('.$record_set.')';
	$result = $mysqli->query($sql_stmt);

	// prepare output
	if ($result === TRUE)
		return $mysqli->insert_id;
	else
		return $mysqli->error;
}

function sql_select_all ($mysqli, $tb)
{
	$sql_stmt = 'SELECT * FROM `'.$tb.'` ORDER BY id ASC';
	$result = $mysqli->query($sql_stmt);
	if ($result->num_rows > 0)
	{
		$new_array = array();
		while ($row = $result->fetch_assoc())
			array_push($new_array,$row);
		return $new_array;
	}
	else
		return $mysqli->error;
}

function sql_select_one ($mysqli, $tb, $field, $value)
{
	$sql_stmt = 'SELECT * FROM `'.$tb.'` WHERE '.$field.'="'.$mysqli->real_escape_string($value).'"';
	$result = $mysqli->query($sql_stmt);
	if ($result->num_rows > 0)
	{
		$new_array = array();
		while ($row = $result->fetch_assoc())
			array_push($new_array,$row);
		return current($new_array);
	}
	else
		return $mysqli->error;
} 

function sql_select_id ($mysqli, $tb, $id)
{
	$sql_stmt = 'SELECT * FROM `'.$tb.'` WHERE id="'.$mysqli->real_escape_string($id).'"';
	$result = $mysqli->query($sql_stmt);
	if ($result->num_rows > 0)
	{
		$new_array = array();
		while ($row = $result->fetch_assoc())
			array_push($new_array,$row);
		return current($new_array);
	}
	else
		return $mysqli->error;
} 

function sql_select_count ($mysqli, $tb, $field, $value)
{
	$sql_stmt = 'SELECT COUNT(id) AS var FROM `'.$tb.'` WHERE '.$field.'="'.$mysqli->real_escape_string($value).'"';	
	$result = sql_query($mysqli, $sql_stmt);		
	return (int) $result[0]['var'];
}	

function sql_select ($mysqli, $tb, $field, $value)
{
	$sql_stmt = 'SELECT * FROM `'.$tb.'` WHERE '.$field.'="'.$mysqli->real_escape_string($value).'"';
	$result = $mysqli->query($sql_stmt);
	if ($result->num_rows > 0)
	{
		$new_array = array();
		while ($row = $result->fetch_assoc())
			array_push($new_array,$row);
		return $new_array;
	}
	else
		return $mysqli->error;
} 

function sql_update ($mysqli, $tb, $post_array, $field, $value)
{		
	$hash_map = '';
	// extract set clause
	foreach ($post_array as $k => $v) 
		$hash_map .= $k.'="'.$mysqli->real_escape_string($v).'", ';
	$hash_map = rtrim($hash_map,', ');
	
	// execute sql command
	$sql_stmt = 'UPDATE `'.$tb.'` SET '.$hash_map.' WHERE '.$field.'="'.$mysqli->real_escape_string($value).'"';
	$result = $mysqli->query($sql_stmt); 
	
	// prepare output
	if ($result === TRUE) 
		return $mysqli->affected_rows;	
	else
		return $mysqli->error;	
}

function sql_delete ($mysqli, $tb, $field, $value)
{		
	$sql_stmt = 'DELETE FROM `'.$tb.'` WHERE '.$field.'="'.$mysqli->real_escape_string($value).'"';
	$result = $mysqli->query($sql_stmt);
	if ($result === TRUE) 
		return $mysqli->affected_rows;	
	else
		return $mysqli->error;	
} 

function sql_query ($mysqli, $sql_stmt)
{
	$type = substr($sql_stmt,0,6);
	
	$result =	$mysqli->query($sql_stmt);
	if ($type == 'SELECT')
	{
		if ($result->num_rows > 0) {
			$new_array = array();
			while ($row = $result->fetch_assoc())
				array_push($new_array,$row);
			return $new_array;
		}
		else
			return $mysqli->error;
	}
	else
	{ 
		if ($result === TRUE)	{
			if ($type == 'INSERT')
				return $mysqli->insert_id;
			else
				return $mysqli->affected_rows;
		}
		else
			return $mysqli->error;
	}	
}

function sql_cell ($mysqli, $tb, $col, $field, $value)
{
	$sql_stmt = 'SELECT '.$col.' FROM `'.$tb.'` WHERE '.$field.'="'.$mysqli->real_escape_string($value).'"';
 	$result = sql_query($mysqli, $sql_stmt);
	if (is_array($result))
		return $result[0][$col];
	return $result;
}

function sql_column_distinct ($mysqli, $tb, $col = 'id')
{
	$sql_stmt = 'SELECT id, '.$col.' FROM `'.$tb.'` GROUP BY '.$col;
 	$result = sql_query($mysqli, $sql_stmt);
	if (is_array($result)) {
		$new_array = array();
		foreach ($result as $assoc) {
			$key = $assoc['id'];
			$new_array[$key] = $assoc[$col];
		}
		return $new_array;
	}
}	

function sql_column ($mysqli, $tb, $col = 'id')
{
	$sql_stmt = 'SELECT id, '.$col.' FROM `'.$tb.'`';
 	$result = sql_query($mysqli, $sql_stmt);
	if (is_array($result)) {
		$new_array = array();
		foreach ($result as $assoc) {
			$key = $assoc['id'];
			$new_array[$key] = $assoc[$col];
		}
		return $new_array;
	}
}	

function sql_columns ($mysqli, $tb, $cols)
{
	$sql_stmt = 'SELECT id, '.$cols.' FROM `'.$tb.'`';
 	$result = sql_query($mysqli, $sql_stmt);
	if (is_array($result)) {
		$new_array = array();
		foreach ($result as $assoc) {
			$key = $assoc['id'];
			$new_array[$key] = array_shift($assoc);
		}
		return $new_array;
	}
}	

function sql_count ($mysqli, $tb, $col = 'id')
{
	$sql_stmt = 'SELECT COUNT('.$col .') AS var FROM `'.$tb.'`';
	$result = sql_query($mysqli, $sql_stmt);		
	return (int) $result[0]['var'];
}	

function sql_sum ($mysqli, $tb, $col  = 'id')
{
	$sql_stmt = 'SELECT SUM('.$col .') AS var FROM `'.$tb.'`';
	$result = sql_query($mysqli, $sql_stmt);		
	return (int) $result[0]['var'];
}	

function sql_avg ($mysqli, $tb, $col  = 'id')
{
	$sql_stmt = 'SELECT AVG('.$col .') AS var FROM `'.$tb.'`';
	$result = sql_query($mysqli, $sql_stmt);		
	return (int) $result[0]['var'];
}	

function sql_min ($mysqli, $tb, $col  = 'id')
{
	$sql_stmt = 'SELECT MIN('.$col .') AS var FROM `'.$tb.'`';
	$result = sql_query($mysqli, $sql_stmt);		
	return (int) $result[0]['var'];
}	

function sql_max ($mysqli, $tb, $col  = 'id')
{
	$sql_stmt = 'SELECT MAX('.$col .') AS var FROM `'.$tb.'`';
	$result = sql_query($mysqli, $sql_stmt);		
	return (int) $result[0]['var'];
}	

function sql_first ($mysqli, $tb)
{
	$sql_stmt = 'SELECT * FROM `'.$tb.'` ORDER BY id ASC LIMIT 1';
	$result = sql_query($mysqli, $sql_stmt);
	return is_array($result)? current($result): $result;
}

function sql_last ($mysqli, $tb)
{
	$sql_stmt = 'SELECT * FROM `'.$tb.'` ORDER BY id DESC LIMIT 1';
	$result = sql_query($mysqli, $sql_stmt);
	return is_array($result)? current($result): $result;
}

function sql_group_by ($mysqli, $tb, $col)
{
	$sql_stmt = 'SELECT * FROM `'.$tb.'` GROUP BY '.$col.' ORDER BY id ASC';
	$result = sql_query($mysqli, $sql_stmt);
	return is_array($result)? array_map(current,$result): $result;		
}

function sql_distinct ($mysqli, $tb, $col) 
{
	$sql_stmt = 'SELECT DISTINCT '.$col.' FROM `'.$tb.'`';
	$result = sql_query($mysqli, $sql_stmt);		
	return is_array($result)? array_map(current,$result): $result;			
}	

function sql_distinct_count ($mysqli, $tb, $col) 
{
	$sql_stmt = 'SELECT COUNT(DISTINCT '.$col.') AS var FROM `'.$tb.'`';
	$result = sql_query($mysqli, $sql_stmt);		
	if (is_array($result))
		return (int) $result[0]['var'];
	return 0;
}	

function sql_rand ($mysqli, $tb, $lmt = 25)
{
	$sql_stmt = 'SELECT * FROM `'.$tb.'` ORDER BY RAND() LIMIT '.$lmt;		
	$result = sql_query($mysqli, $sql_stmt);		
	return $result;
}

function sql_today ($mysqli, $tb, $col = 'date', $today = NULL)
{
	$today = is_null($today)? date('Y-m-d'): $today;	
	$sql_stmt = 'SELECT * FROM `'.$tb.'` WHERE DATE('.$col.')>="'.$today.'" ORDER BY id ASC';
	$result = sql_query($mysqli, $sql_stmt);		
	return $result;
}	

function sql_recent ($mysqli, $tb)
{
	$row = sql_last($mysqli, $tb);
	$recent = date('Y-m-d', strtotime($row['date']));
	$result = sql_today($mysqli, $tb, 'date', $recent);
	return $result;	
}	

# SESSION SUB-ROUTINE
function start_session ($key, $value) 
{
	session_start();
}

function stop_session () 
{
	session_destroy(); 
}

function end_session () 
{
	session_unset(); 
}

function set_session ($key, $value) 
{
	$_SESSION[$key] = $value;
}

function get_sessions ($key) 
{
	return $_SESSION;
}

function get_session ($key) 
{
	return $_SESSION[$key];
}

function del_session ($key) 
{
	unset($_SESSION[$key]);
}

# MAIL SUB-ROUTINE
function send_mail ($from, $to, $subject, $body)
{
	$message = wordwrap($body, 70, "\r\n");
	$headers = "From: " . $from . "\r\n";
	$headers .= 'X-Mailer: PHP/'.phpversion();
	$compose = mail($to, $subject, $message, $headers);
	return $_SERVER['SERVER_NAME'] == 'localhost'? true: $compose; 
}

function send_mail_markup ($from, $to, $subject, $body)
{
	// $from eg. "Staff Name" <staff@company.com>
	$message = $body;
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= "From: " . $from . "\r\n";
	$compose = mail($to, $subject, $message, $headers);
	return $_SERVER['SERVER_NAME'] == 'localhost'? true: $compose;
}

# FILESYSTEM SUB-ROUTINE
function read_folder ($dir) 
{
	return glob($dir . '*');
}
function file_crawl ($dir = './', &$results = array()) 
{
	$files = scandir($dir); 
	foreach ($files as $key => $value) 
	{
		$path = realpath($dir . DIRECTORY_SEPARATOR . $value); 
		if (! is_dir($path))
			$results[] = $path;
		else if ($value != "." && $value != "..") {
			file_crawl($path, $results); 
			$results[] = $path; 
		} 
	} 
	return $results;
}
function file_exist ($file_name) 
{
	return file_exists($file_name);
}	

function file_ext ($file_name) 
{
	return pathinfo($file_name, PATHINFO_EXTENSION);
}	

function upload_file ($file_array, $dir, $use_file_name = NULL) 
{
	$ext = '.' . pathinfo($file_array['name'], PATHINFO_EXTENSION);	
	$gen_file_name = 'IMG_' . date('Ymd') . '_' . date('His');
	$new_file_name = is_null($use_file_name)? $gen_file_name . $ext: $use_file_name . $ext;
	
	$from = $file_array['tmp_name'];
	$to = $dir . $new_file_name;
	return move_uploaded_file($from, $to)? $new_file_name: false;
}	

function rename_file ($old_file_name, $new_file_name) 
{
	return rename($old_file_name, $new_file_name);
} 

function create_file ($file_name, $content) 
{
	$file_syst = fopen($file_name, 'w+') or die('Unable to open file!');
	$file_size = fwrite($file_syst, $content);
	fclose($file_syst);
	return $file_size;
}

function read_file ($file_name) 
{
	$file_syst = fopen($file_name, 'r+') or die('Unable to open file!');
	$content = fread($file_syst, filesize($file_name));
	fclose($file_syst);
	return $content;
}

function update_file ($file_name, $content) 
{
	$file_syst = fopen($file_name, 'a+') or die('Unable to open file!');
	$file_size = fwrite($file_syst, $content);
	fclose($file_syst);
	return $file_size;
}

function delete_file ($file_name, $dir) 
{
	$target = $dir . $file_name;
/*	if ($_SERVER['SERVER_NAME'] !== 'localhost') {
		$ftp_dir = dirname($_SERVER['DOCUMENT_ROOT'] . $_SERVER['PHP_SELF']) . '/';
		$target = $ftp_dir . $dir . $file_name;
	}*/
	return unlink($target);
} 

# XML SUB-ROUTINE
function xml_header ($xml_str)
{
	return '<?xml version="1.0" encoding="UTF-8" ?>';
}

function xml_to_object ($xml_str)
{
	$xml_obj = json_encode($xml_str);
	return json_decode($xml_obj);
}

function xml_to_array ($xml_str)
{
	$xml_obj = json_encode($xml_str);
	return json_decode($xml_obj, true);
}

function convert_to_xml ($assoc_array)
{
	$buf = '';
	foreach ($assoc_array as $key => $value) 
	{
		$buf = '<' . $key . '>';
		$buf .= htmlentities($value);
		$buf .= '</' . $key . '>';
		$xm_str .= $buf . '\n';
	}
	return '<node>\n'. $xm_str .'</node>';
}

# JSON SUB-ROUTINE
function json_header ()
{
	header('Content-Type:application/json;charset=UTF-8');
}

function json_to_object ($json_str)
{
	return json_decode($json_str);
}

function json_to_array ($json_str)
{
	return json_decode($json_str, true);
}

function convert_to_json ($assoc_array)
{
	return json_encode($assoc_array);
}

# JAVASCRIPT SUB-ROUTINE
function alert ($args)
{
	echo '<script type="text/javascript">alert("'.$args.'");</script>';	
}	

function goto_page ($page)
{
	echo '<script type="text/javascript">location.assign("'.$page.'");</script>';	
}

function reload_page ()
{
	echo '<script type="text/javascript">location.reload();</script>';	
}

function print_page ()
{
	echo '<script type="text/javascript">window.print();</script>';	
}	

function is_online ()
{
	// website, port  (try 80 or 443)
	$connect = @fsockopen('www.fsockopen.com',80);
	if ($connect)	
	{
		return fclose($connect);
	}
	else 
	{
		return false;
	}
}	

# MISC SUB-ROUTINE
function page_name ($page)
{
	return basename($_SERVER['PHP_SELF']);
}

function go_to ($page)
{
	header('location: ' . $page);
	exit();
}

function enum_f ($array, $i) 
{
	if (array_key_exists($i, $array)) 
		return $array[$i];
	if (in_array($i, $array)) 
		return array_search($i, $array);
}

function null_f ($args, $null = 'N/A') 
{
	if (strlen($args) > 0) 
		return $args;
	else
		return $null;
}

function alt_f ($args, $alt = 0) 
{
	if (strlen($args) > 0) 
		return $args;
	else
		return $alt;
}

function money_f ($amount) 
{
	return number_format($amount);
}

function trim_f ($date_time)
{
	// 2020-04-21 12:47:00
	$date_time = str_replace(' ','',$date_time); // 2020-04-2112:47:00
	$date_time = str_replace('-','',$date_time); // 2020042112:47:00
	$date_time = str_replace(':','',$date_time); // 20200421124700
	
	$date_time = str_replace('_','',$date_time); // delimiters
	$date_time = str_replace(',','',$date_time);
	$date_time = str_replace('/','',$date_time);
	return $date_time;
}

function proxy_f ($date_time, $id)
{
	return trim_f($date_time) . $id;
}

function date_f ($date_time)
{
	return date('D, M d, Y', strtotime($date_time));
}

function time_f ($date_time)
{
	return date('H:i A', strtotime($date_time));
}

function now () 
{
	return date('Y-m-d H:i:s');
}

function when ($date, $days)
{
	$arr = explode('-', $date);
	$from = mktime(0,0,0, $arr[1], $arr[2], $arr[0]);
	$to = strtotime('+'.$days.' days', $from);
	return date('Y-m-d', $to);
}

function keygen ($n = 6)
{
	$buf = '';
	for ($i = 0; $i < $n; $i++)
		$buf .= mt_rand(1,9);
	return $buf;
}

function my_ip ()
{	
	// get IP
	if ($_SERVER['HTTP_CLIENT_IP']) 
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	else if ($_SERVER['HTTP_X_FORWARDED_FOR']) 
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	else if ($_SERVER['HTTP_X_FORWARDED']) 
		$ip = $_SERVER['HTTP_X_FORWARDED'];
	else if ($_SERVER['HTTP_FORWARDED_FOR']) 
		$ip = $_SERVER['HTTP_FORWARDED_FOR'];
	else if ($_SERVER['HTTP_FORWARDED']) 
		$ip = $_SERVER['HTTP_FORWARDED'];
	else if ($_SERVER['REMOTE_ADDR']) 
		$ip = $_SERVER['REMOTE_ADDR'];
	else 
		$ip = $_SERVER['SERVER_ADDR'];
	
	// validate IP
	if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) === false) 
		return $ip;
	else if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) === false) 
		return $ip;
	else 
		return $ip;
}

?>

