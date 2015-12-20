<?php
/**
 * @package DiRocco
 */
$modality_theme_options = modality_get_options( 'modality_theme_options' );
?>
<div id="header-top">
	<div class="pagetop-inner clearfix">
		<div class="top-left left">
			<form id="demo-b" role="search" method="get" class="search-form" action="">
				<label>
					<input type="search" class="search-field" placeholder="Search …" value="" name="s" title="Search for:">				
					<!--<input type="search" class="search-field" placeholder="Search">-->
				</label>
			</form>
		</div>
		<div class="top-right right">
			<?php wp_nav_menu( array('menu' => 'top-menu' )); ?>
			<!--<a href="#">Login</a><a href="#">Register</a><a href="<?php //get_site_url(); ?>">Cart</a>-->
		</div>
	</div>
</div>