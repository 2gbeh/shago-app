<?php require_once 'inc/top.php'; ?>  
<main class="home">
  <section class="search">
  <div class="wrap">
    <div class="caption">
      <!-- Buy anything from Farm Center, Kano State -->
      <span class="desktop">      
        Siyan komai daga Farm Center
        <var><i class="fa fa-map-marker-alt"></i> Kano State</var>
      </span> 
      <span class="mobile">      
        Siyan komai daga 
        <var><i class="fa fa-map-marker-alt"></i> Farm Center</var>
      </span>                
    </div>
    
    <form <?php echo ACTION; ?>>
    <table border="0">
    <tr>
      <td>
        <input type="search" name="k" placeholder="Search goods and services" required />
      </td>
      <td width="1px">
        <button type="submit"><i class="fa fa-search"></i></button>
      </td>
    </tr>
    </table>
    </form>
  </div>  
  </section>
  
  <section class="niche">  
  <div class="wrap">
    <?php echo $category; ?>
  </div>
  </section>
</main>  
<?php require_once 'inc/end.php'; ?>  


