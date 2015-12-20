<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>
<link rel="stylesheet" type="text/css" href="<?=get_template_directory_uri()?>/slik/slick.css"/>
<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>
<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

<h1 class="page-title-shop">
  <?php woocommerce_page_title(); ?>
</h1>
<h2 class="page-subtitle-shop">Exhibition one</h2>
<?php endif; ?>
<?php
			/**
			 * woocommerce_archive_description hook
			 *
			 * @hooked woocommerce_taxonomy_archive_description - 10
			 * @hooked woocommerce_product_archive_description - 10
			 */
			do_action( 'woocommerce_archive_description' );
		?>
<?php if ( have_posts() ) : ?>
<?php
				/**
				 * woocommerce_before_shop_loop hook
				 *
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			?>
<?php woocommerce_product_loop_start(); ?>
<?php woocommerce_product_subcategories(); ?>
<?php while ( have_posts() ) : the_post(); ?>
<li <?php post_class( $classes ); ?>>
  <?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
  <?php $url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
  
   global $product;
	 $attachment_ids = $product->get_gallery_attachment_ids();
	
	?>
  <div class="slik_product_slider">
  	<div><a href="<?php the_permalink()?>"><img src="<?=$url?>" width="70%" height="200" style="margin:0px auto;"></a></div>
    <?php
    foreach( $attachment_ids as $attachment_id ) 
	{
	  $image_link = wp_get_attachment_url( $attachment_id );
	  ?>
      <div><a href="<?php the_permalink()?>"><img src="<?=$image_link?>" width="70%" height="200" style="margin:0px auto;"></a></div>
      <?php
		}
		?>
        
  </div>
  <div>
    <div class="col-lg-3">
      <h2 class="single_view_model animated fadeIn">
        <a href="<?php the_permalink()?>"><?php the_title() ?></a>
      </h2>
      <span class="single_view_linearooni animated slideInLeft"></span>
      <div class="single_view_small_meta">
        <?php the_excerpt() ?>
      </div>
    </div>
    <div class="col-lg-3 pull-right">
    
    <img src="<?=$url?>" width="50" onClick="next_slide(0)">
      <?php
	 $counter = 0;
	foreach( $attachment_ids as $attachment_id ) 
	{
		$counter++;
	  $image_link = wp_get_attachment_url( $attachment_id );
	  ?>
      <img src="<?=$image_link?>" width="50" onClick="next_slide(<?=$counter?>)">
      <?php
		}
		?>
    </div>
    <div class="clearfix"></div>
    <div class="content-product-price">
      <?php
                                            /**
                                         * woocommerce_after_shop_loop_item_title hook
                                         *
                                         * @hooked woocommerce_template_loop_rating - 5
                                         * @hooked woocommerce_template_loop_price - 10
                                         */
                                        do_action( 'woocommerce_after_shop_loop_item_title' );
                                ?>
    </div>
  </div>
  <?php
                    
                            /**
                             * woocommerce_after_shop_loop_item hook
                             *
                             * @hooked woocommerce_template_loop_add_to_cart - 10
                             */
                            //do_action( 'woocommerce_after_shop_loop_item' );
                    
                        ?>
</li>
<?php endwhile; // end of the loop. ?>
<?php woocommerce_product_loop_end(); ?>
<?php
				/**
				 * woocommerce_after_shop_loop hook
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>
<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>
<?php wc_get_template( 'loop/no-products-found.php' ); ?>
<?php endif; ?>
<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>
<?php get_footer( 'shop' ); ?>


<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="<?=get_template_directory_uri()?>/slik/slick.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
      $('.slik_product_slider').slick({
		  infinite: false,
		  arrows : false,
      });
    });
	
	function next_slide(no)
	{
		$('.slik_product_slider').slick('slickGoTo', no);
	}
  </script>