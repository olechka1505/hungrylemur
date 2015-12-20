<?php
/**
 * Template Name: Category Journal
 *
 * @package DiRocco
 */
get_header(); ?>
	<div id="main" class="col1 row">
<h2 class="home-page-h3">Journal</h3>
			<?php
			$args = array( 'posts_per_page' => 6, 'order'=> 'ASC', 'category' => get_cat_ID( 'journals' ) );
			$myposts = get_posts( $args );
			foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
				<div class="world-journal-home images col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<li>
						<div class="new-wrapper hover08 column cell">
						<a href="<?php the_permalink() ?>">
						<?php the_post_thumbnail(); ?>
						<h3 class="text-content" id="text"><span class="subtitle"><?php the_subtitle(); ?></span><br><span><?php the_title(); ?></span></h3>
						</a>
					</div>
					</li>
				</div>
			<?php endforeach; 
			wp_reset_postdata();?>
			<div class="clearfix"></div>
</div>
<?php get_footer(); ?>