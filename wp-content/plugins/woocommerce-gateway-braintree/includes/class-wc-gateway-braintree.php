<?php
/**
 * WooCommerce Braintree Gateway
 *
 * This source file is subject to the GNU General Public License v3.0
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@skyverge.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade WooCommerce Braintree Gateway to newer
 * versions in the future. If you wish to customize WooCommerce Braintree Gateway for your
 * needs please refer to http://docs.woothemes.com/document/braintree/
 *
 * @package   WC-Braintree/Gateway
 * @author    SkyVerge
 * @copyright Copyright (c) 2011-2015, SkyVerge, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Braintree Base Gateway Class
 *
 * Handles common functionality among the Credit Card/PayPal gateways
 *
 * @since 2.0.0
 */
class WC_Gateway_Braintree extends SV_WC_Payment_Gateway_Direct {


	/** sandbox environment ID */
	const ENVIRONMENT_SANDBOX = 'sandbox';

	/** @var string production merchant ID */
	protected $merchant_id;

	/** @var string production public key */
	protected $public_key;

	/** @var string production private key */
	protected $private_key;

	/** @var string sandbox merchant ID */
	protected $sandbox_merchant_id;

	/** @var string sandbox public key */
	protected $sandbox_public_key;

	/** @var string sandbox private key */
	protected $sandbox_private_key;

	/** @var string name dynamic descriptor */
	protected $name_dynamic_descriptor;

	/** @var string phone dynamic descriptor */
	protected $phone_dynamic_descriptor;

	/** @var string url dynamic descriptor */
	protected $url_dynamic_descriptor;

	/** @var \WC_Braintree_API instance */
	protected $api;

	/** @var array shared settings names */
	protected $shared_settings_names = array( 'public_key', 'private_key', 'merchant_id', 'sandbox_public_key', 'sandbox_private_key', 'sandbox_merchant_id', 'name_dynamic_descriptor' );


	/**
	 * Enqueue the Braintree.js library prior to enqueueing gateway scripts
	 *
	 * @since 3.0.0
	 * @return bool
	 */
	public function enqueue_scripts() {

		if ( $this->is_available() ) {

			// the gateway's JS replaces all the functionality provided by the framework JS
			wp_dequeue_script( 'sv-wc-payment-gateway-frontend' );
			wp_dequeue_script( 'jquery-payment' );

			// braintree.js library
			wp_enqueue_script( 'braintree-js', 'https://js.braintreegateway.com/v2/braintree.js', array(), WC_Braintree::VERSION, true );

			// frontend CSS
			wp_enqueue_style( 'wc-braintree', $this->get_plugin()->get_plugin_url() . '/assets/css/frontend/wc-braintree.min.css', array(), WC_Braintree::VERSION );
		}

		return parent::enqueue_scripts();
	}


	/**
	 * Add the braintree client token to the localized script params
	 *
	 * @since 3.0.0
	 * @return array
	 */
	protected function get_js_localize_script_params() {

		$params = parent::get_js_localize_script_params();

		if ( $this->is_payment_form_page() ) {

			$params['generic_error_message'] = __( 'Oops, something went wrong. Please try a different payment method.', WC_Braintree::TEXT_DOMAIN );

			// client token
			try {

				$result = $this->get_api()->get_client_token( array( 'merchantAccountId' => $this->get_merchant_account_id() ) );

				$params['client_token'] = $result->get_client_token();

			} catch ( SV_WC_Plugin_Exception $e ) {

				$this->add_debug_message( $e->getMessage(), 'error' );
			}
		}

		return $params;
	}


	/**
	 * Validate the payment nonce exists
	 *
	 * @since 3.0.0
	 * @param $is_valid
	 * @return bool
	 */
	public function validate_payment_nonce( $is_valid ) {

		// nonce is required
		if ( ! SV_WC_Helper::get_post( 'wc_' . $this->get_id() . '_payment_nonce' ) ) {

			wc_add_notice( __( 'Oops, there was a temporary payment error. Please try another payment method or contact us to complete your transaction.', WC_Braintree::TEXT_DOMAIN ), 'error' );

			$is_valid = false;
		}

		return $is_valid;
	}


	/**
	 * Add Braintree-specific data to the order prior to processing, currently:
	 *
	 * $order->payment->nonce - payment method nonce
	 * $order->payment->tokenize - true to tokenize payment method, false otherwise
	 *
	 * @since 3.0.0
	 * @see SV_WC_Payment_Gateway_Direct::get_order()
	 * @param int $order order ID being processed
	 * @return \WC_Order object with payment and transaction information attached
	 */
	public function get_order( $order ) {

		$order = parent::get_order( $order );

		$order->payment->nonce = SV_WC_Helper::get_post( 'wc_'. $this->get_id() . '_payment_nonce' );
		$order->payment->tokenize = $this->should_tokenize_payment_method();

		// billing address ID if using existing payment token
		if ( ! empty( $order->payment->token ) ) {

			$token = $this->get_payment_token( $order->get_user_id(), $order->payment->token );

			if ( $billing_address_id = $token->get_billing_address_id() ) {
				$order->payment->billing_address_id = $billing_address_id;
			}
		}

		// fraud tool data as a JSON string, unslashed as WP slashes $_POST data which breaks the JSON
		$order->payment->device_data = wp_unslash( SV_WC_Helper::get_post( 'device_data' ) );

		// merchant account ID
		if ( $merchant_account_id = $this->get_merchant_account_id( $order->get_order_currency() ) ) {
			$order->payment->merchant_account_id = $merchant_account_id;
		}

		// dynamic descriptors
		$order->payment->dynamic_descriptors        = new stdClass();
		$order->payment->dynamic_descriptors->name  = $this->get_name_dynamic_descriptor();
		$order->payment->dynamic_descriptors->phone = $this->get_phone_dynamic_descriptor();
		$order->payment->dynamic_descriptors->url   = $this->get_url_dynamic_descriptor();

		// test amount when in sandbox mode
		if ( $this->is_test_environment() && ( $test_amount = SV_WC_Helper::get_post( 'wc-' . $this->get_id_dasherized() . '-test-amount' ) ) ) {
			$order->payment_total = SV_WC_Helper::number_format( $test_amount );
		}

		return $order;
	}


	/** Tokenization methods **************************************************/


	/**
	 * Braintree tokenizes payment methods during the transaction (if successful)
	 *
	 * @since 3.0.0
	 * @return bool
	 */
	public function tokenize_with_sale() {
		return true;
	}


	/**
	 * Return a custom payment token class instance
	 *
	 * @since 3.0.0
	 * @see SV_WC_Payment_Gateway_Direct::build_payment_token()
	 * @param string $token_id token ID
	 * @param array $data token data
	 * @return \WC_Braintree_Payment_Method
	 */
	public function build_payment_token( $token_id, $data ) {

		return new WC_Braintree_Payment_Method( $token_id, $data );
	}


	/**
	 * When retrieving payment methods via the Braintree API, it returns both
	 * credit/debit card *and* PayPal methods from a single call. Overriding
	 * the core framework update method ensures that PayPal accounts aren't saved to
	 * the credit card token meta entry, and vice versa.
	 *
	 * @since 3.0.0
	 * @param int $user_id WP user ID
	 * @param array $tokens array of tokens
	 * @param string $environment_id optional environment id, defaults to plugin current environment
	 * @return string updated user meta id
	 */
	protected function update_payment_tokens( $user_id, $tokens, $environment_id = null ) {

		foreach ( $tokens as $token_id => $token ) {

			if ( ( $this->is_credit_card_gateway() && ! $token->is_credit_card() ) || ( ! $this->is_credit_card_gateway() && ! $token->is_paypal_account() ) ) {
				unset( $tokens[ $token_id ] );
			}
		}

		return parent::update_payment_tokens( $user_id, $tokens, $environment_id );
	}


	/** Admin settings methods ************************************************/


	/**
	 * Returns an array of form fields specific for this method
	 *
	 * @since 3.0.0
	 * @see SV_WC_Payment_Gateway::get_method_form_fields()
	 * @return array of form fields
	 */
	protected function get_method_form_fields() {

		return array(

			// production
			'public_key' => array(
				'title'       => __( 'Public Key', WC_Braintree::TEXT_DOMAIN ),
				'type'        => 'text',
				'class'    => 'environment-field production-field',
				'desc_tip'    => __( 'The Public Key for your Braintree account.', WC_Braintree::TEXT_DOMAIN ),
			),

			'private_key' => array(
				'title'       => __( 'Private Key', WC_Braintree::TEXT_DOMAIN ),
				'type'        => 'password',
				'class'    => 'environment-field production-field',
				'desc_tip'    => __( 'The Private Key for your Braintree account.', WC_Braintree::TEXT_DOMAIN ),
			),

			'merchant_id' => array(
				'title'       => __( 'Merchant ID', WC_Braintree::TEXT_DOMAIN ),
				'type'        => 'text',
				'class'    => 'environment-field production-field',
				'desc_tip'    => __( 'The Merchant ID for your Braintree account.', WC_Braintree::TEXT_DOMAIN ),
			),

			// sandbox
			'sandbox_public_key' => array(
				'title'       => __( 'Sandbox Public Key', WC_Braintree::TEXT_DOMAIN ),
				'type'        => 'text',
				'class'    => 'environment-field sandbox-field',
				'desc_tip'    => __( 'The Public Key for your Braintree sandbox account.', WC_Braintree::TEXT_DOMAIN ),
			),

			'sandbox_private_key' => array(
				'title'       => __( 'Sandbox Private Key', WC_Braintree::TEXT_DOMAIN ),
				'type'        => 'password',
				'class'    => 'environment-field sandbox-field',
				'desc_tip'    => __( 'The Private Key for your Braintree sandbox account.', WC_Braintree::TEXT_DOMAIN ),
			),

			'sandbox_merchant_id' => array(
				'title'       => __( 'Sandbox Merchant ID', WC_Braintree::TEXT_DOMAIN ),
				'type'        => 'text',
				'class'    => 'environment-field sandbox-field',
				'desc_tip'    => __( 'The Merchant ID for your Braintree sandbox account.', WC_Braintree::TEXT_DOMAIN ),
			),

			// merchant account ID per currency feature
			'merchant_account_id_title' => array(
				'title'       => __( 'Merchant Account IDs', WC_Braintree::TEXT_DOMAIN ),
				'type'        => 'title',
				'description' => sprintf(
					esc_html__( 'Enter additional merchant account IDs if you do not want to use your Braintree account default. %1$sLearn more about merchant account IDs%2$s', WC_Braintree::TEXT_DOMAIN ),
					'<a href="' . esc_url( wc_braintree()->get_documentation_url() ). '#merchant-account-ids' . '">', '&nbsp;&rarr;</a>'
				),
			),

			'merchant_account_id_fields' => array( 'type' => 'merchant_account_ids' ),

			// dynamic descriptors
			'dynamic_descriptor_title' => array(
				'title'       => __( 'Dynamic Descriptors', WC_Braintree::TEXT_DOMAIN ),
				'type'        => 'title',
				'description' => esc_html__( 'Dynamic descriptors define what will appear on your customers\' credit card statements for a specific purchase. Contact Braintree to enable these for your account.', WC_Braintree::TEXT_DOMAIN ),
			),

			'name_dynamic_descriptor' => array(
				'title'    => __( 'Name', WC_Braintree::TEXT_DOMAIN ),
				'type'     => 'text',
				'class'    => 'js-dynamic-descriptor-name',
				'desc_tip' => __( 'The value in the business name field of a customer\'s statement. Company name/DBA section must be either 3, 7 or 12 characters and the product descriptor can be up to 18, 14, or 9 characters respectively (with an * in between for a total descriptor name of 22 characters).', WC_Braintree::TEXT_DOMAIN ),
				'custom_attributes' => array( 'maxlength' => 22 ),
			),

			'phone_dynamic_descriptor' => array(
				'title' => __( 'Phone', WC_Braintree::TEXT_DOMAIN ),
				'type' => 'text',
				'class' => 'js-dynamic-descriptor-phone',
				'desc_tip' => __( 'The value in the phone number field of a customer\'s statement. Phone must be exactly 10 characters and can only contain numbers, dashes, parentheses and periods.', WC_Braintree::TEXT_DOMAIN ),
				'custom_attributes' => array( 'maxlength' => 10 ),
			),

			'url_dynamic_descriptor' => array(
				'title' => __( 'URL', WC_Braintree::TEXT_DOMAIN ),
				'type' => 'text',
				'class' => 'js-dynamic-descriptor-url',
				'desc_tip' => __( 'The value in the URL/web address field of a customer\'s statement. The URL must be 13 characters or less.', WC_Braintree::TEXT_DOMAIN ),
				'custom_attributes' => array( 'maxlength' => 13 ),
			),
		);
	}


	/** Merchant account ID (multi-currency) feature **************************/


	/**
	 * Generate the merchant account ID section HTML, including the currency
	 * selector and any existing merchant account IDs that have been entered
	 * by the admin
	 *
	 * @since 3.0.0
	 * @return string HTML
	 */
	protected function generate_merchant_account_ids_html() {

		$base_currency = get_woocommerce_currency();

		$button_text = sprintf( __( 'Add merchant account ID for %s', WC_Braintree::TEXT_DOMAIN ), $base_currency );

		// currency selector
		ob_start();
		?>
		<tr valign="top">
			<th scope="row" class="titledesc">
				<select id="wc_braintree_merchant_account_id_currency" class="wc-enhanced-select">
					<?php foreach ( get_woocommerce_currencies() as $code => $name ) : ?>
						<option <?php selected( $code, $base_currency ); ?> value="<?php echo esc_attr( $code ); ?>">
							<?php echo esc_html( sprintf( '%s (%s)', $name, get_woocommerce_currency_symbol( $code ) ) ); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</th>
			<td class="forminp">
				<a href="#" class="button js-add-merchant-account-id"><?php echo esc_html( $button_text ); ?></a>
			</td>
		</tr>
		<?php

		$html = ob_get_clean();
		// generate HTML for saved merchant account IDs
		foreach ( array_keys( $this->settings ) as $key ) {
			if ( preg_match( '/merchant_account_id_[a-z]{3}$/', $key ) ) {

				$currency = substr( $key, -3 );

				$html .= $this->generate_merchant_account_id_html( $currency );
			}
		}

		return $html;
	}


	/**
	 * Display the settings page with some additional CSS/JS to support the
	 * merchant account IDs feature
	 *
	 * @since 3.0.0
	 * @see SV_WC_Payment_Gateway::admin_options()
	 */
	public function admin_options() {

		parent::admin_options();

		?>
		<style type="text/css">.js-remove-merchant-account-id .dashicons-trash { margin-top: 5px; opacity: .4; } .js-remove-merchant-account-id { text-decoration: none; }</style>
		<?php

		ob_start();
		?>
		// sync add merchant account ID button text to selected currency
		$( 'select#wc_braintree_merchant_account_id_currency' ).change( function() {
			$( '.js-add-merchant-account-id' ).text( '<?php esc_html_e( 'Add merchant account ID for ', WC_Braintree::TEXT_DOMAIN ); ?>' + $( this ).val() )
		} );

		// add new merchant account ID field
		$( '.js-add-merchant-account-id' ).click( function( e ) {
			e.preventDefault();

			var row_fragment = '<?php echo $this->generate_merchant_account_id_html(); ?>',
				currency     = $( 'select#wc_braintree_merchant_account_id_currency' ).val();

			// replace currency placeholders with selected currency
			row_fragment = row_fragment.replace( /{{currency_display}}/g, currency ).replace( /{{currency_code}}/g, currency.toLowerCase() );

			// prevent adding more than 1 merchant account ID for the same currency
			if ( $( 'input[name="' + $( row_fragment ).find( '.js-merchant-account-id-input' ).attr( 'name' ) + '"]' ).length ) {
				return;
			}

			// inject field HTML
			if ( $( '.js-merchant-account-id-input' ).length ) {
				$( '.js-merchant-account-id-input' ).closest( 'tr' ).last().after( row_fragment );
			} else {
				$( this ).closest( 'tr' ).after( row_fragment );
			}
		} );

		// delete existing merchant account ID
		$( '.form-table' ).on( 'click', '.js-remove-merchant-account-id', function( e ) {
			e.preventDefault();

			$( this ).closest( 'tr' ).delay( 50 ).fadeOut( 400, function() {
				$( this ).remove();
			} );
		} );
		<?php

		wc_enqueue_js( ob_get_clean() );
	}


	/**
	 * Generate HTML for an individual merchant account ID field
	 *
	 * @since 3.0.0
	 * @param string|null $currency_code 3 character currency code for the merchant account ID
	 * @return string HTML
	 */
	protected function generate_merchant_account_id_html( $currency_code = null ) {

		if ( is_null( $currency_code ) ) {

			// set placeholders to be replaced by JS for new account account IDs
			$currency_display = '{{currency_display}}';
			$currency_code = '{{currency_code}}';

		} else {

			// used passed in currency code
			$currency_display = strtoupper( $currency_code );
			$currency_code = strtolower( $currency_code );
		}

		$id    = sprintf( 'woocommerce_%s_merchant_account_id_%s', $this->get_id(), $currency_code );
		$title = sprintf( __( 'Merchant Account ID (%s)', WC_Braintree::TEXT_DOMAIN ), $currency_display );

		ob_start();
		?>
		<tr valign="top">
			<th scope="row" class="titledesc">
				<label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $title ) ?></label>
			</th>
			<td class="forminp">
				<fieldset>
					<legend class="screen-reader-text"><span><?php echo esc_html( $title ) ?></span></legend>
					<input class="input-text regular-input js-merchant-account-id-input" type="text" name="<?php printf( 'woocommerce_%s_merchant_account_id[%s]', esc_attr( $this->get_id() ), esc_attr( $currency_code ) ); ?>" id="<?php echo esc_attr( $id ); ?>" value="<?php echo esc_attr( $this->get_option( "merchant_account_id_{$currency_code}" ) ); ?>" placeholder="<?php esc_attr_e( 'Enter merchant account ID', WC_Braintree::TEXT_DOMAIN ); ?>" />
					<a href="#" title="<?php esc_attr_e( 'Remove this merchant account ID', WC_Braintree::TEXT_DOMAIN ); ?>" class="js-remove-merchant-account-id"><span class="dashicons dashicons-trash"></span></a>
				</fieldset>
			</td>
		</tr>
		<?php

		// newlines break JS when this HTML is used as a fragment
		return trim( preg_replace( "/[\n\r\t]/",'', ob_get_clean() ) );
	}


	/**
	 * Override the normal field validation to dynamically inject valid merchant
	 * account IDs so they're persisted to settings
	 *
	 * @since 3.0.0
	 * @see WC_Settings_API::validate_settings_fields()
	 * @param array $form_fields, unused
	 */
	public function validate_settings_fields( $form_fields = array() ) {

		parent::validate_settings_fields( $form_fields );

		// remove fields used only for display
		unset( $this->sanitized_fields['merchant_account_id_title'] );
		unset( $this->sanitized_fields['merchant_account_ids'] );
		unset( $this->sanitized_fields['dynamic_descriptor_title'] );

		$merchant_account_id_field_key = sprintf( 'woocommerce_%s_merchant_account_id', $this->get_id() );

		// add merchant account IDs
		if ( ! empty( $_POST[ $merchant_account_id_field_key ] ) ) {

			$currency_codes = array_keys( get_woocommerce_currencies() );

			foreach ( $_POST[ $merchant_account_id_field_key ] as $currency => $merchant_account_id ) {

				// sanity check for valid currency
				if ( ! in_array( strtoupper( $currency ), $currency_codes ) ) {
					continue;
				}

				// add to persisted fields
				$this->sanitized_fields[ 'merchant_account_id_' . strtolower( $currency ) ] = wp_kses_post( trim( stripslashes( $merchant_account_id ) ) );
			}
		}
	}


	/** Getters ***************************************************************/


	/**
	 * Returns the customer ID for the given user ID. Braintree provides a customer
	 * ID after creation.
	 *
	 * @since 3.0.0
	 * @see SV_WC_Payment_Gateway::get_customer_id()
	 * @param int $user_id WP user ID
	 * @param array $args optional additional arguments which can include: environment_id, autocreate (true/false), and order
	 * @return string payment gateway customer id
	 */
	public function get_customer_id( $user_id, $args = array() ) {

		$defaults = array(
			'environment_id' => $this->get_environment(),
			'autocreate'     => false,
			'order'          => null,
		);

		$args = array_merge( $defaults, $args );

		return parent::get_customer_id( $user_id, $args );
	}


	/**
	 * Returns the merchant account transaction URL for the given order
	 *
	 * @since 3.0.0
	 * @see WC_Payment_Gateway::get_transaction_url()
	 * @param \WC_Order $order the order object
	 * @return string transaction URL
	 */
	public function get_transaction_url( $order ) {

		$merchant_id    = $this->get_merchant_id();
		$transaction_id = $this->get_order_meta( $order->id, 'trans_id' );
		$environment    = $this->get_order_meta( $order->id, 'environment' );

		if ( $merchant_id && $transaction_id ) {

			$this->view_transaction_url = sprintf( 'https://%s.braintreegateway.com/merchants/%s/transactions/%s',
				$this->is_test_environment( $environment ) ? 'sandbox' : 'www',
				$merchant_id,
				$transaction_id
			);
		}

		return parent::get_transaction_url( $order );
	}


	/**
	 * Returns true if the gateway is properly configured to perform transactions
	 *
	 * @since 3.0.0
	 * @see SV_WC_Payment_Gateway::is_configured()
	 * @return boolean true if the gateway is properly configured
	 */
	protected function is_configured() {

		$is_configured = parent::is_configured();

		// missing configuration
		if ( ! $this->get_merchant_id() || ! $this->get_public_key() || ! $this->get_private_key() ) {
			$is_configured = false;
		}

		return $is_configured;
	}


	/**
	 * Returns true if the current page contains a payment form
	 *
	 * @since 3.0.0
	 * @return bool
	 */
	public function is_payment_form_page() {

		return ( is_checkout() && ! is_order_received_page() ) || is_checkout_pay_page() || is_add_payment_method_page();
	}


	/**
	 * Get the API object
	 *
	 * @since 3.0.0
	 * @see SV_WC_Payment_Gateway::get_api()
	 * @return \WC_Braintree_API instance
	 */
	public function get_api() {

		if ( is_object( $this->api ) ) {
			return $this->api;
		}

		$includes_path = $this->get_plugin()->get_plugin_path() . '/includes';

		// main API class
		require_once( $includes_path . '/api/class-wc-braintree-api.php' );

		// response message helper
		require_once( $includes_path . '/api/class-wc-braintree-api-response-message-helper.php' );

		// requests
		require_once( $includes_path . '/api/requests/abstract-wc-braintree-api-request.php' );
		require_once( $includes_path . '/api/requests/class-wc-braintree-api-client-token-request.php' );
		require_once( $includes_path . '/api/requests/class-wc-braintree-api-transaction-request.php' );
		require_once( $includes_path . '/api/requests/abstract-wc-braintree-api-vault-request.php' );
		require_once( $includes_path . '/api/requests/class-wc-braintree-api-customer-request.php' );
		require_once( $includes_path . '/api/requests/class-wc-braintree-api-payment-method-request.php' );
		require_once( $includes_path . '/api/requests/class-wc-braintree-api-payment-method-nonce-request.php' );

		// responses
		require_once( $includes_path . '/api/responses/abstract-wc-braintree-api-response.php' );
		require_once( $includes_path . '/api/responses/class-wc-braintree-api-client-token-response.php' );
		require_once( $includes_path . '/api/responses/abstract-wc-braintree-api-transaction-response.php' );
		require_once( $includes_path . '/api/responses/class-wc-braintree-api-credit-card-transaction-response.php' );
		require_once( $includes_path . '/api/responses/class-wc-braintree-api-paypal-transaction-response.php' );
		require_once( $includes_path . '/api/responses/abstract-wc-braintree-api-vault-response.php' );
		require_once( $includes_path . '/api/responses/class-wc-braintree-api-customer-response.php' );
		require_once( $includes_path . '/api/responses/class-wc-braintree-api-payment-method-response.php' );
		require_once( $includes_path . '/api/responses/class-wc-braintree-api-payment-method-nonce-response.php' );

		return $this->api = new WC_Braintree_API( $this );
	}


	/**
	 * Returns true if the current gateway environment is configured to 'sandbox'
	 *
	 * @since 3.0.0
	 * @see SV_WC_Payment_Gateway::is_test_environment()
	 * @param string $environment_id optional environment id to check, otherwise defaults to the gateway current environment
	 * @return boolean true if $environment_id (if non-null) or otherwise the current environment is test
	 */
	public function is_test_environment( $environment_id = null ) {

		// if an environment is passed in, check that
		if ( ! is_null( $environment_id ) ) {
			return self::ENVIRONMENT_SANDBOX === $environment_id;
		}

		// otherwise default to checking the current environment
		return $this->is_environment( self::ENVIRONMENT_SANDBOX );
	}


	/**
	 * Returns the merchant ID based on the current environment
	 *
	 * @since 3.0.0
	 * @param string $environment_id optional one of 'sandbox' or 'production', defaults to current configured environment
	 * @return string merchant ID
	 */
	public function get_merchant_id( $environment_id = null ) {

		if ( is_null( $environment_id ) ) {
			$environment_id = $this->get_environment();
		}

		return self::ENVIRONMENT_PRODUCTION === $environment_id ? $this->merchant_id : $this->sandbox_merchant_id;
	}


	/**
	 * Returns the public key based on the current environment
	 *
	 * @since 3.0.0
	 * @param string $environment_id optional one of 'sandbox' or 'production', defaults to current configured environment
	 * @return string public key
	 */
	public function get_public_key( $environment_id = null ) {

		if ( is_null( $environment_id ) ) {
			$environment_id = $this->get_environment();
		}

		return self::ENVIRONMENT_PRODUCTION === $environment_id ? $this->public_key : $this->sandbox_public_key;
	}


	/**
	 * Returns the private key based on the current environment
	 *
	 * @since 3.0.0
	 * @param string $environment_id optional one of 'sandbox' or 'production', defaults to current configured environment
	 * @return string private key
	 */
	public function get_private_key( $environment_id = null ) {

		if ( is_null( $environment_id ) ) {
			$environment_id = $this->get_environment();
		}

		return self::ENVIRONMENT_PRODUCTION === $environment_id ? $this->private_key : $this->sandbox_private_key;
	}


	/**
	 * Return the merchant account ID for the given currency and environment
	 *
	 * @since 3.0.0
	 * @param string|null $currency optional currency code, defaults to base WC currency
	 * @return string|null
	 */
	public function get_merchant_account_id( $currency = null ) {

		if ( is_null( $currency ) ) {
			$currency = get_woocommerce_currency();
		}

		$key = 'merchant_account_id_' . strtolower( $currency );

		return isset( $this->$key ) ? $this->$key : null;
	}


	/**
	 * Return an array of valid Braintree environments
	 *
	 * @since 3.0.0
	 * @return array
	 */
	protected function get_braintree_environments() {

		return array( self::ENVIRONMENT_PRODUCTION => __( 'Production' ), self::ENVIRONMENT_SANDBOX => __( 'Sandbox' ) );
	}


	/**
	 * Return the name dynamic descriptor
	 *
	 * @link https://developers.braintreepayments.com/reference/request/transaction/sale/php#descriptor.name
	 * @since 3.0.0
	 * @return string
	 */
	public function get_name_dynamic_descriptor() {

		return $this->name_dynamic_descriptor;
	}


	/**
	 * Return the phone dynamic descriptor
	 *
	 * @link https://developers.braintreepayments.com/reference/request/transaction/sale/php#descriptor.phone
	 * @since 3.0.0
	 * @return string
	 */
	public function get_phone_dynamic_descriptor() {
		return $this->phone_dynamic_descriptor;
	}


	/**
	 * Return the URL dynamic descriptor
	 *
	 * @link https://developers.braintreepayments.com/reference/request/transaction/sale/php#descriptor.url
	 * @since 3.0.0
	 * @return string
	 */
	public function get_url_dynamic_descriptor() {
		return $this->url_dynamic_descriptor;
	}


}
