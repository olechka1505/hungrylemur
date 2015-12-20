<?php
/**
 * The template for displaying the footer.
 *
 *
 * @package Modality
 */ 
$modality_theme_options = modality_get_options( 'modality_theme_options' );?>
    <div id="footer" class="section">
	<div class="clear"></div>
	<?php if ( $modality_theme_options['footer_widgets'] == '1') { ?>
		<div id="footer-wrap">
			<?php  get_sidebar('footer'); ?>
		</div><!--footer-wrap-->
	<?php } ?>
	<?php wp_nav_menu( array('menu' => 'footer-menu' )); ?>
	</div><!--footer-->
</div><!--grid-container-->
<?php wp_footer(); ?>
<script>
jQuery(document).ready(function()
{
    jQuery('#sf-sidebar form.superfly').attr('action','<?php echo get_bloginfo('url'); ?>');
});
</script>
<script type="text/javascript" src="http://vjs.zencdn.net/c/video.js"></script>
</body>
</html>