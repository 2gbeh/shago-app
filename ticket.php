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
        <label for="subject">subject</label>
        <select id="subject" name="subject">
        	<option></option>
        	<option>Abuse</option>
        	<option>Billing</option>          
        	<option>Sales</option>
        	<option>Security</option>
        	<option>Support</option>
        </select>
      </td>
    </tr>
    <tr>
      <td>
        <label for="message">message</label>
        <textarea id="message" name="message" 
     placeholder="Type message here.." rows="5" required></textarea>
      </td>
    </tr>   
    <tr> 
      <td>
        <button type="submit">Submit Ticket</button>
        <div class="help_cover">
          <a href="account.php">Return to previous page</a>
        </div>        
      </td>
    </tr>
    </table>
    </form> 
  </div>  
</main>  
<?php require_once 'inc/end.php'; ?>  


