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

if (isset($_GET['q']))
{
	$dir_array = explode(',',$_GET['q']);
	$buf = '';
	foreach ($dir_array as $dir)
	{
		if (is_dir($dir) && $dh = opendir($dir))
		{
			$buf = ''; $i = 0;
			while (($file = readdir($dh)) !== false)
			{
				if (strpos($file,'.')/* && !strpos($file,'.txt')*/)
				{
					$i++;					
					$link = $dir . $file;
					$name = current(explode('.',$file));
					
					$buf .= '<li>
						<a href="'.$link.'">
							<table border="0">
								<tr valign="middle">
									<td><div class="thumb">'.$i.'</div></td>
									<td><div class="title">'.$file.'</div></td>
									<td><div class="caret">&rsaquo;</div></td>
								</tr>
							</table>
						</a>
					</li>';
				}
			}
			$data .= '<ul>
				<li class="section">
					<div class="meta">total: '.$i.'</div> 
					dir: '.$dir.'
				</li>
				'.$buf.'
			</ul>';
		}
		closedir($dh);
	}
}

$res = new stdClass();
$res->data = $data;
echo json_encode($res);

?>


