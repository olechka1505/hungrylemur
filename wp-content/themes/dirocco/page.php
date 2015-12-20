<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Modality
 */
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
	<?php
		// Start the Loop.
		while ( have_posts() ) : the_post(); ?>
<div id="fullpagenone">
<div class="content-posts-wrap">
	<div id="content-box">
		<div id="post-body">
			<div <?php post_class('post-single'); ?>>

				<h1 id="post-title" <?php post_class('entry-title'); ?>><?php the_title(); ?> </h1>
				<?php 
				if ($modality_theme_options['breadcrumbs'] == '1') { ?>

			<?php } 
				 
				if ( has_post_thumbnail() ) { 
						
					if ($modality_theme_options['featured_img_post'] == '1') {?>
						<div class="thumb-wrapper">
							<?php the_post_thumbnail('full'); ?>
						</div><!--thumb-wrapper-->
					<?php
					} 
						
				} ?>
				<div id="article" class="content-page-dirocco">
					<?php the_content(); 
					the_tags('<p class="post-tags"><span>'.__('Tags:','modality').'</span> ','','</p>');
					wp_link_pages( array(
						'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'modality' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
					) );
					
					//Displays navigation to next/previous post.
					if ( $modality_theme_options['post_navigation'] == 'below') { get_template_part('post','nav'); }
				
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template( '', true );
					} ?>
			
				</div><!--article-->
			</div><!--post-single-->
				<?php get_template_part('post','sidebar'); ?>
		</div><!--post-body-->
	</div><!--content-box-->

</div><!--content-posts-wrap-->
	<?php	
		endwhile;
	?>
	</div><!--main-->
<?php if ($modality_theme_options['social_section_on'] == '1') {
	get_template_part( 'social', 'section' );	
}
get_footer(); ?>
</div>