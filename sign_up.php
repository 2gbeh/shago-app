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
        <label for="full_name">name</label>
        <input type="text" id="full_name" name="full_name" value="" 
		 maxlength="50" required placeholder="Full Name" />
      </td>
    </tr>
    <tr>
      <td>
        <label for="email">email</label>
        <input type="email" id="email" name="email" value="" 
		placeholder="handle@domain.com" maxlength="50" required />
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
        <button type="submit">Create Account</button>
      </td>
    </tr>
    <tr>
      <td>
        <div class="next_cover">
          <span>Already have an account?</span>
          <a href="sign_in.php" title="Login">Sign in</a>
        </div>
      </td>
    </tr>
    </table>
    </form> 
  </div>  
</main>  
<?php require_once 'inc/end.php'; ?>  


