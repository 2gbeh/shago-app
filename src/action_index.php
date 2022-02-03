<?PHP
$iter = 1;
$tr = $td = '';
$arr = $list_cat;

for ($i = 0; $i < count($arr); $i++)
{
	$href = $arr[$i][0];
	$icon = $arr[$i][1];
	$name = $arr[$i][2];
	
	$td .= '<td>
		<a href="?'.$href.'">
			<i class="'.$icon.'"></i>
			<var>'.$name.'</var>
		</a>
	</td>';
	
	$iter++;
	
	if ($iter == 4)	{
		 $tr .= '<tr>'.$td.'</tr>';
		 $td = '';
		 $iter = 1;
	}				
}

$category = '<table border="0">'.$tr.'</table>';

?>