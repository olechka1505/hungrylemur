<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
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
			fitToSection: true,
			afterLoad: function() {
				// if (jQuery(window).width() >= 1027) {
				// 	jQuery.fn.fullpage.setFitToSection(true);
				// }
			}
		});
	});

	$(function(){
		$('#main-home-video2').css({'height':(($(window).height())-10)+'px'});
	
	  $(window).resize(function(){
	          $('#main-home-video2').css({'height':(($(window).height())-10)+'px'});
    });
})
/*$(document).ready(function() {
  $('.play-video').on('click', function(ev) {
 
    $("#video")[0].src += "&autoplay=1";
    ev.preventDefault();
 
  });
});*/
</script>
<div id="main" class="<?php echo esc_attr($modality_theme_options['layout_settings']); ?>">
	<div id="fullpage">
		<div class="section slider2" style="height: 100%;">
			<div id="main-home-video2" class="main-home-video2">
				<img src="../../../wp-content/uploads/2016/01/MGG_DETAIL-HOME-2.jpg" alt="">
				<!-- <img src="http://dev.hungrylemur.com/wp-content/uploads/2015/09/MGG_FRONT.jpg"/> -->
			</div>

		</div>
		<!-- newest storytellers -->
		<div class="section">
			<!--<h3 class="home-page-h3">Newest</h3>--!>
			<h2 class="home-page-h3">Newest Storytellers</h3>
			<?php query_posts('cat=8&showposts=6'); ?>
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php if (get_the_title() != 'WRENCH') { ?>
				
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
				
			<?php } ?>		
			<?php endwhile; endif; ?>
			<div class="clearfix"></div>
		</div>
		<!-- ./newest storytellers -->


		<!-- our story -->
		<div class="section">
			<!--<h3 class="home-page-h3">Our</h3>--!>
			<h2 class="home-page-h3">Our Story</h3>
			<?php query_posts('cat=13&showposts=1'); ?>
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<div class="world-journal-home padding-0 row">
					<li>
					
<?php /* Remove this temporarily until we have the video ready	
						<a class="world-journal-thumb" href="<?php the_permalink() ?>"><?php the_post_thumbnail(); ?></a>
						<div class="our-story-desc col-sm-12 col-lg-4">
						
						
							<a href="<?php the_permalink() ?>"><h2><?php the_subtitle(); ?></h2></a>
							<a href="<?php the_permalink() ?>"><h3><?php the_title(); ?></h3></a>							
							<p class="our-story-desc-description"><a href="<?php the_permalink() ?>"><?php echo get_excerpt(80); ?></a></p>
							<a href="<?php the_permalink() ?>"><img src="http://hungrylemur.com/wp-content/themes/dirocco/images/play.png" class="play-image" alt="play" /></a>
<p class="icon"><a href="<?php the_permalink() ?>"><i class="fa fa-play"></i></a></p>
*/?>

						<a class="world-journal-thumb" href="<?php get_home_url() ?>/about"><?php the_post_thumbnail(); ?></a>
						<div class="our-story-desc col-sm-12 col-lg-4">
							<a href="<?php get_home_url() ?>/about"><h2><?php the_subtitle(); ?></h2></a>
							<a href="<?php get_home_url() ?>/about"><h3><?php the_title(); ?></h3></a>
							<p class="our-story-desc-description" style="padding-left:12%;"><a href="<?php get_home_url() ?>/about"><?php echo 'The DiRocco Team share the story that lead them to this point.' ?></a></p>
							
						</div>
					</li>
				</div>
			<?php endwhile; endif; ?>
			<div class="clearfix"></div>
		</div>
		<!-- ./our story -->


		<!-- world journal -->
		<div class="section">
			<!--<h3 class="home-page-h3">World</h3>--!>
			<h2 class="home-page-h3">World Journal</h3>
			<?php query_posts('cat=1&showposts=3'); ?>
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<div class="world-journal-home col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<li>
						<div class="new-wrapper hover08 column cell">
							<a class="world-journal-thumb" href="<?php the_permalink() ?>"><?php the_post_thumbnail(); ?></a> <!-- world journal thumb -->
						</div>
						<a class="world-journal-title" href="<?php the_permalink() ?>"><?php the_title(); ?></a> <!-- world journal title -->
						<p class="world-journal-desc"><a href="<?php the_permalink() ?>"><?php echo get_excerpt(180); ?></a></p> <!-- world journal descripion -->
						<div class="post-info">
							<span><?php the_time('m/d/Y') ?> </span> |
							<span>by <?php the_author() ?> </span>
						</div>
					</li>
				</div>
			<?php endwhile; endif; ?>
			<div class="clearfix"></div>
		</div>
		<!-- ./world journal -->


	<div class="section row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<!--<h3 class="home-page-h3">Featured</h3>--!>
			<h2 class="home-page-h3">Featured Piece</h2>
			<div class="featured-price-home">
				<?php $url = get_site_url(); ?>
				<?php echo do_shortcode('[featured_products per_page="1" columns="1"]'); ?>
				<?php /*<div class="explore-all-products col-sm-12">
				<a href="<?php echo $url.'/shop'; ?>">Explore all the fine pieces</a></div>				*/?>
				</div>				
		</div>
		</div>
		<?php if ($modality_theme_options['social_section_on'] == '1') {
			get_template_part( 'social', 'section' );
		} ?>


<div id="footer" class="section row">
	<div class="col-lg-9 col-md-6 centered extra-section">
		<div class="row">
			<h2 class="home-page-h3 last">Hello</h2>
			<div class="col-lg-6 talk">
				<div class="helo-outer">
				<div class="emailhello">EMAIL: <a href="mailto:INFO@DIROCCOEYEWEAR.COM">INFO@DIROCCOEYEWEAR.COM</a></div><div>CALL: 305 515 9173</div>
				</div>
				</div>
				<div class="col-lg-6 talk">
				<div class="helo-outer">
					<p>You are browsing a creation that took over five years to develop.</p>

					<p>In all of its complexities, carbon fiber has its own life. It will not bend to the will of the hands that shape it like metal, plastic, or acetate would.</p>

					<p>At best, it will parlay before a true trixster and artisan; then unwillingly surrender to creation.</p>

					<p>Any divergence and slight differences are due to the artisanal production of this item. They are not to be considered imperfections, but like all creation, birthmarks that make them unique.</p>

					<p>You and we are fortunate. The only thing it asks of us is to think of the time we have left on this planet and get busy living.</p>

				</div>
				</div>
		</div>	
	</div>

	<div class="clear"></div>
	<?php if ( $modality_theme_options['footer_widgets'] == '1') { ?>
		<div id="footer-wrap">
			<?php  get_sidebar('footer'); ?>
			<?php wp_nav_menu( array('menu' => 'footer-menu' )); ?>
		</div><!--footer-wrap-->
	<?php } ?>
	
</div><!--footer-->
</div>
</div>
</div><!--grid-container-->
<?php wp_footer(); ?>
<script type="text/javascript" src="http://vjs.zencdn.net/c/video.js"></script>
</body>