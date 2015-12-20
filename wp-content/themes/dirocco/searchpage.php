<?php
/*
Template Name: Search Page
*/
?>

$modality_theme_options = modality_get_options( 'modality_theme_options' );
get_header(); ?>
<script>
		jQuery(document).ready(function() {
			jQuery('#fullpage').fullpage({
				responsiveWidth: 1027,
				responsiveHeight: 0,
				fitToSection: false,
				afterLoad: function() {
					// if (jQuery(window).width() >= 1027) {
					// 	jQuery.fn.fullpage.setFitToSection(true);
					// }
				}
			});
		});
</script>
	<div id="main" class="<?php echo esc_attr($modality_theme_options['layout_settings']);?>">
	
	<?php get_search_form(); ?>
	
	</div><!--main-->
<?php if ($modality_theme_options['social_section_on'] == '1') {
	get_template_part( 'social', 'section' );	
}
get_footer(); ?>
</div>