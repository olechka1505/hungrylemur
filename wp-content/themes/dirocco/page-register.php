<?php
/**
 * Template Name: Page for registration
 *
 * @package DiRocco
 */

$modality_theme_options = modality_get_options( 'modality_theme_options' );
get_header(); ?>
<style>
input.input-text{
    width: 100%!important;
    padding: 5px!important;
    font-size: 1em!important;
    line-height: 1.25em!important;
}
p.form-row.form-row-first{
	margin: 0 0 6px;
}

ul.woocommerce-error {
    width: 50%;
    margin: 0 auto;
}
</style>
	<div id="main" class="<?php echo esc_attr($modality_theme_options['layout_settings']);?>">
	<?php
		// Start the Loop.
		while ( have_posts() ) : the_post(); ?>

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
<?php // filter hook for include new pages inside the payment method
$get_checkout_url = apply_filters( 'woocommerce_get_checkout_url', WC()->cart->get_checkout_url() ); ?>
	
	<?php wc_print_notices(); ?>

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 register-first" style="float: none; margin: 0 auto;">
	<div class="col-2">	

		<form method="post" class="register main-register">
		
		<h2><?php _e( 'New Account', 'woocommerce' ); ?></h2>

			<?php do_action( 'woocommerce_register_form_start' ); ?>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

				<p class="form-row form-row-wide">
					<input type="text" class="input-text" placeholder="Email address" name="username" id="reg_username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
				</p>

			<?php endif; ?>

			<p class="form-row form-row-wide">
				<input type="email" class="input-text" placeholder="Email Address" name="email" id="reg_email" value="<?php if ( ! empty( $_POST['email'] ) ) echo esc_attr( $_POST['email'] ); ?>" />
			</p>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

				<p class="form-row form-row-wide">
					<input type="password" class="input-text" placeholder="Password" name="password" id="reg_password" />
				</p>

			<?php endif; ?>

			<!-- Spam Trap -->
			<div style="<?php echo ( ( is_rtl() ) ? 'right' : 'left' ); ?>: -999em; position: absolute;"><label for="trap"><?php _e( 'Anti-spam', 'woocommerce' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>

			<?php do_action( 'woocommerce_register_form' ); ?>
			<?php do_action( 'register_form' ); ?>

			<p class="form-row">
				<?php wp_nonce_field( 'woocommerce-register' ); ?>
				<input type="submit" class="button btn-block" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>" />
			</p>

			<?php do_action( 'woocommerce_register_form_end' ); ?>

		</form>

	</div>
	</div>

</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
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
