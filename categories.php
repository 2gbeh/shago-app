<?php require_once 'inc/top.php'; ?>  
<main class="menu">
  <div class="wrap">
		<section>
    	<var>(<?php echo $trending_size; ?>)</var>
    	Top Categories
    </section> 
	  <?php echo $trending; ?>
      
		<section>
    	<var>(<?php echo $sorted_size; ?>)</var>
    	All Categories
    </section>  
	  <?php echo $sorted; ?> 
      
    <section>&nbsp;</section>
  </div>  
</main>  
<?php require_once 'inc/end.php'; ?>  


