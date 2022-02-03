<?PHP
$list = $list_cat;
sort($list);

$hot_sales = array('fabrics_textiles','fashion','phones_tablets');

foreach ($list_cat as $assoc)
{
	$href = $assoc[0];
	$icon = $assoc[1];
	$name = $assoc[2];
	
	$li .= '<li>
		<a href="?'.$href.'">
			<table border="0">
				<tr>
					<td><div class="thumb"><i class="'.$icon.'"></i></div></td>
					<td><div class="title">'.$name.'</div></td>
					<td><div class="caret">&rsaquo;</div></td>
				</tr>
			</table>
		</a>
	</li>';
	
	if (in_array($href,$hot_sales))
	{
		$li_alt .= '<li>
			<a href="?'.$href.'">
				<table border="0">
					<tr>
						<td><div class="thumb"><i class="'.$icon.'"></i></div></td>
						<td><div class="title">'.$name.'</div></td>
						<td><div class="caret">&rsaquo;</div></td>
					</tr>
				</table>
			</a>
		</li>';	
	}
}
$sorted = '<ul>'.$li.'</ul>';
$sorted_size = count($list);

$trending = '<ul>'.$li_alt.'</ul>';
$trending_size = 3;

?>