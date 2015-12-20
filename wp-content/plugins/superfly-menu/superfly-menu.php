<div id="sf-sidebar" style="opacity:0" class="sf-hl-<?php echo $options['sf_highlight']; if($options['sf_ind'] == 'yes') echo ' sf-indicators'?> sf-compact">
	  <div class="sf-scroll-wrapper">
	    <div class="sf-scroll">
			<div class="sf-logo">
				<?php if(!empty($options['sf_tab_logo'])): ?><a href="<?php echo site_url() ?>"><img src="<?php echo
                    is_ssl() ?
                        str_replace('http:', 'https:', $options['sf_tab_logo']) :
                        str_replace('https:', 'http:', $options['sf_tab_logo']) ; ?>"
                                                         alt=""></a><?php endif; ?>
				<div class="sf-title">
				<?php if(!empty($options['sf_first_line'])) echo '<h3>'.$options['sf_first_line'].'</h3>';?>
				<?php if(!empty($options['sf_sec_line'])) echo '<h4>'.$options['sf_sec_line'].'</h4>';?>
				</div>
			</div>
	    <nav class="sf-nav">			<?php 			$defaults0 = array(		      'menu'            => 'top main-menu',			  		   );	 	      		  ?>			<div class="top-menu"><?php echo wp_nav_menu( $defaults0 ); ?> </div>			<div class="white-space">
<form id="demo-b" role="search" method="get" class="superfly" action="<?php get_site_url(); ?>">
				<label>
					<input type="search" class="search-field" placeholder="Search …" value="" name="s" title="Search for:">				
				</label>
			</form>
</div>
		    <div class="sf-va-middle">
	      <?php
	      $defaults = array(
		      'theme_location'  => '',
		      'menu'            => $options['sf_active_menu'],
		      'container'       => '',
		      'container_class' => '',
		      'container_id'    => '',
		      'menu_class'      => 'menu',
		      'menu_id'         => 'sf-nav',
		      'echo'            => true,
		      'fallback_cb'     => 'wp_page_menu',
		      'before'          => '',
		      'after'           => '',
		      'link_before'     => '',
		      'link_after'      => '',
		      'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		      'depth'           => 0,
		      'walker'          => ''
	      );
		  $defaults1 = array(		      'menu'            => $options['sf_active_menu'],			  		   );	  
	      wp_nav_menu( $defaults1 );
	      ?>
		    <div class="widget-area"><?php dynamic_sidebar('sf_sidebar_widget_area');?></div>		    </div>
		    <!-- INSERT HERE -->
	    </nav>

		    <!-- CUSTOM CONTENT HERE -->
		    <ul class="sf-social"></ul>

	    </div>
    </div>
    <div class="sf-sidebar-bg"></div>
    <div class="sf-rollback sf-color1 sf-label-<?php echo $options['sf_label_vis']; ?> sf-label-<?php echo $options['sf_label_style'];echo $options['sf_label_text'] == 'yes' ? ' sf-label-text' : '' ;  ?>" style>
        <div class="sf-navicon-button x">
            <div class="sf-navicon"></div>
        </div>
    </div>
		<div class="sf-view sf-view-level-custom">
			<span class="sf-close"></span>
			<?php
			foreach ($sf_menu_data as $key => $val) {
				$curr = sf_deparam($val);
				if (empty($curr['content'])) continue;
				echo '<div class="sf-custom-content" id="sf-cc-'.$key.'"><div class="sf-content-wrapper">' . do_shortcode(urldecode($curr['content'])) . '</div></div>';
			}
			?>
		</div>
</div>

<?php if ($options['sf_mob_nav'] === 'yes') {
	echo '<div id="sf-mob-navbar"><div class="sf-navicon-button x">
      <div class="sf-navicon"></div>
  </div>';
	if(!empty($options['sf_tab_logo'])) {
		echo '<a href="/"><img src="'. $options['sf_tab_logo'] . '" alt=""></a>';
	}
	echo '</div>';
}
?>

<div id="sf-overlay-wrapper"><div id="sf-overlay"></div></div>




