<?php 
/**
 * @package Modality
 */
?>
<div class="post-info">	
	<span><?php printf(esc_attr( get_the_date())); ?> </span>
	<span class="separator"> | </span>
	<span><?php _e('by ','modality'); printf(esc_url(the_author_posts_link())); ?> </span>
</div>