<?php
/*
Template Name: Debug
*/
get_header();
?>
		<pre>
		<?php 
		$data_r = print_r($data, true); 
		$data_r_sans = htmlspecialchars($data_r, ENT_QUOTES); 
		echo $data_r_sans; ?>
		</pre>
	
<?php get_footer(); ?>
