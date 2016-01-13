<?php
/**
 * Edit account form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<script type='text/javascript'>
/* Toggle Change Password fields */
function showDiv() {
   document.getElementById('change-password').style.display = "visible";
   document.getElementById('change-password').style.display = "block";
   document.getElementById('change-password-button').style.display = "none";
}
</script>


<?php wc_print_notices(); ?>

<h1 class="main-account-title">ACCOUNT</h1>
<h2 class="main-account-subtitle">Hello, <?php echo esc_attr( $user->first_name ); ?>. Welcome to your account</h2>

<form action="" class="my-account-edit" method="post">
	<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">	
		<?php do_action( 'woocommerce_edit_account_form_start' ); ?>	
		<h2>Edit</h2>
		<p class="form-row form-row-first">
			<input type="text" class="input-text" placeholder="First name" name="account_first_name" id="account_first_name" value="<?php echo esc_attr( $user->first_name ); ?>" />
		</p>
		<p class="form-row form-row-last">
			<input type="text" class="input-text" placeholder="Last name" name="account_last_name" id="account_last_name" value="<?php echo esc_attr( $user->last_name ); ?>" />
		</p>
		<div class="clear"></div>
		<p class="form-row form-row-wide">
			<input readonly type="email" class="input-text" placeholder="Email address" name="account_email" id="account_email" value="<?php echo esc_attr( $user->user_email ); ?>" />
		</p>
		<p class="form-row form-row-wide">
			<input type="button" id="change-password-button" class="button" name="answer" value="Change Password" onclick="showDiv()" />
		</p>
	</div>
	
	<div id="change-password" style="display:none;" class="col-lg-3 col-md-3 col-sm-12 col-xs-12 change-password">
		<fieldset>
			<!--<legend><?php //_e( 'Password Change', 'woocommerce' ); ?></legend>-->

			<p class="form-row form-row-wide">
				<input type="password" class="input-text" placeholder="Current password" name="password_current" id="password_current" />
			</p>
			<p class="form-row form-row-wide">
				<input type="password" class="input-text" placeholder="New passwords" name="password_1" id="password_1" />
			</p>	
			<p class="form-row form-row-wide">
				<input type="password" class="input-text" placeholder="Confirm new password" name="password_2" id="password_2" />
			</p>
		</fieldset>
		
	</div>
	
    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style="float:right;">
	<?php wc_get_template('myaccount/my-address.php'); ?>
	</div>
	
	<div class="clear"></div>

	<?php do_action( 'woocommerce_edit_account_form' ); ?>

	<p class="edit-account-submit-button">
		<?php wp_nonce_field( 'save_account_details' ); ?>
		<input type="submit" class="button" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>" />
		<input type="hidden" name="action" value="save_account_details" />
	</p>

	<?php do_action( 'woocommerce_edit_account_form_end' ); ?>
	

</form>
