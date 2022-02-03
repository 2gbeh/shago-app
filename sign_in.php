<?php require_once 'inc/top.php'; ?>  
<main class="landing">
	<div class="wrap">
    <form <?php echo FORM_ATTRIB; ?>>
    <legend>
    	<div class="title"><?php echo $new_caption->title; ?></div>
      <div class="subtitle"><?php echo $new_caption->subtit; ?></div>
    </legend>
    <table border="0">
    <tr>
      <td>
        <label for="username">username</label>
        <input type="search" id="username" name="username" value="" 
		 maxlength="25" required />
      </td>
    </tr>
    <tr>
      <td>
        <div class="password_cover">
          <label for="password">password</label>      
          <input type="password" id="password" name="password" value="" 
		 maxlength="25" required />
          <a onClick="togglePassword()" title="Show/Hide">SHOW</a>
        </div>
      </td>
    </tr>         
    <tr> 
      <td>
        <button type="submit">Log in</button>
        <div class="help_cover">
          <a href="sign_in_help.php" title="Retrieve Password">Forgot Password</a>
        </div>
      </td>
    </tr>
    <tr>
      <td>
        <div class="next_cover">
          <span>Don't have an account?</span>
          <a href="sign_up.php" title="Register">Sign up</a>
        </div>
      </td>
    </tr>
    </table>
    </form> 
  </div>  
</main>  
<?php require_once 'inc/end.php'; ?>  


