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
        <label for="email">email</label>
        <input type="email" id="email" name="email" value="" 
		placeholder="handle@domain.com" maxlength="50" required />
      </td>
    </tr>
    <tr> 
      <td>
        <button type="submit">Send Email</button>
      </td>
    </tr>
    <tr>
      <td>
        <div class="next_cover">
          <span>Return to </span>
          <a href="sign_up.php" title="Register">Sign up</a> or
          <a href="sign_in.php" title="Login">Sign in</a>          
        </div>
      </td>
    </tr>
    </table>
    </form> 
  </div>  
</main>  
<?php require_once 'inc/end.php'; ?>  


