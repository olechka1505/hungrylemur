<?php
/**
 * Template Name: Category Stories
 *
 * @package DiRocco
 */
get_header(); ?>
	<div id="main" class="col1 row">
<h2 class="home-page-h3">Stories</h3>
			<?php query_posts('cat=8&showposts=6'); ?>
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div class="world-journal-home images col-lg-4 col-md-4 col-sm-12 col-xs-12 ">
				<li>
					<div class="new-wrapper hover08 column cell">
						<a href="<?php the_permalink() ?>">
						<?php the_post_thumbnail(); ?>
						<h3 class="text-content" id="text"><span class="subtitle"><?php the_subtitle(); ?></span><br><span><?php the_title(); ?></span></h3>
						</a>
					</div>
				</li>
				</div>
			<?php endwhile; endif; ?>
			<div class="clearfix"></div>
</div>
<?php get_footer(); ?>