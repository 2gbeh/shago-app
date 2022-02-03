<?php 	
	require_once 'lib/jrad/php/master.php';
	require_once 'lib/jrad/php/widget.php';
	include_once 'src/_config_page.php';	
	include_once 'src/_config_app.php';
	include_once 'src/class_main.php';
	include_once 'src/glob_shared.php';
	include_once 'src/'.$page_ctx_action;	
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php 
	include_once 'inc/meta.php';
	include_once 'inc/head.php';
?>
</head>
<body class="template">
<header>
  <div class="wrap">
    <table border="0">
    <tr>
      <td width="1px">
        <a href="test/" onClick="toggleAside()" class="drawerr" title="Menu">&equiv;</a>
      </td>
      <td width="1px">
        <a href="index.php">
          <img src="img/typeface.png" class="logo" alt="" title="Home" />
        </a>  
      </td>
      <td align="right">
        <a href="cart.php" title="View Cart">
          <i class="fa fa-shopping-cart"></i>
        </a>
        
        <a href="sign_in.php" title="My Profile">
          <i class="fa fa-user"></i>
        </a>      
      </td>
    </tr>
    </table>
  </div> 
  <div id="google_translate_element" style="float:right;"></div>   
</header>

<aside></aside>