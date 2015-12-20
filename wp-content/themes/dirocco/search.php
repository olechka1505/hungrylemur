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

<div id="fullpagenone">
<div class="content-posts-wrap">
	<div id="content-box">
		<div id="post-body">
			<div <?php post_class('post-single'); ?>>

				<h1 id="post-title" <?php post_class('entry-title'); ?>><?php printf( __( 'Search Results for: %s', 'twentyfourteen' ), get_search_query() ); ?></h1>
				<?php if ( have_posts() ) : ?>
				<?php 
					while ( have_posts() ) : the_post(); ?>

<div <?php post_class('post-single'); ?>>

				<a href="<?php the_permalink() ?>"><h1 id="post-title" <?php post_class('entry-title'); ?>><?php the_title(); ?> </h1></a>
				<?php 
				if ($modality_theme_options['breadcrumbs'] == '1') { ?>

			<?php } 
				 
				if ( has_post_thumbnail() ) { 
						
					if ($modality_theme_options['featured_img_post'] == '1') {?>
						<div class="thumb-wrapper" style="text-align:center;">
							<a href="<?php the_permalink() ?>"><?php the_post_thumbnail('full'); ?></a>
						</div><!--thumb-wrapper-->
					<?php
					} 
						
				} ?>
				<div id="article" class="content-page-dirocco">
					<a href="<?php the_permalink() ?>"><?php the_excerpt(); ?></a>
				</div><!--article-->
			</div><!--post-single-->
						<?php endwhile;

				else :
					// If no content, include the "No posts found" template.
					get_template_part( 'content', 'none' );

				endif;
			?>
			<?php posts_nav_link( ' &#183; ', '< previous page', 'next page >' ); ?>
			</div><!--post-single-->
				<?php get_template_part('post','sidebar'); ?>
		</div><!--post-body-->
	</div><!--content-box-->

</div><!--content-posts-wrap-->
	</div><!--main-->
<?php if ($modality_theme_options['social_section_on'] == '1') {
	get_template_part( 'social', 'section' );	
}
get_footer(); ?>
</div>