<?php


if (! defined('ABSPATH')) {
    exit();
}

// Setting API of option page


add_action( 'admin_menu', 'hatc_login_add_admin_menu' );
add_action( 'admin_init', 'hatc_login_settings_init' );

// Submenu page in WooCommerce menu
function hatc_login_add_admin_menu() { 

	add_submenu_page( 'woocommerce', 'Login to see add to cart and prices', 'Login to see add to cart and prices', 'manage_options', 'login_to_see_add_to_cart_prices', 'hatc_login_options_page' );

}


function hatc_login_settings_init() { 

	register_setting( 'pluginPage', 'ic_settings' );

	add_settings_section(
		'ic_pluginPage_section', 
		__( 'Settings of the plugin', 'hatc_login_plugin' ), 
		'hatc_login_settings_section_callback', 
		'pluginPage'
	);

	add_settings_field( 
		'hatc_login_checkbox_field_0', 
		__( 'Turn off WooCommerce for guest costumers', 'hatc_login_plugin' ), 
		'hatc_login_checkbox_field_0_render', 
		'pluginPage', 
		'ic_pluginPage_section' 
	);

		
	add_settings_field( 
		'hatc_login_text_field_0', 
		__( 'Personalized text for add to cart button for guests', 'hatc_login_plugin' ), 
		'hatc_login_text_field_0_render', 
		'pluginPage', 
		'ic_pluginPage_section' 
	);
	
	
	add_settings_field( 
		'hatc_login_text_field_1', 
		__( 'Personalized link for add to cart button for guests', 'hatc_login_plugin' ), 
		'hatc_login_text_field_1_render', 
		'pluginPage', 
		'ic_pluginPage_section' 
	);


	add_settings_field( 
		'hatc_login_checkbox_field_3', 
		__( 'Turn off products prices for guests', 'hatc_login_plugin' ), 
		'hatc_login_checkbox_field_3_render', 
		'pluginPage', 
		'ic_pluginPage_section' 
	);

	
		add_settings_field( 
		'hatc_login_text_field_2', 
		__( 'Personalized text for prices field for guests', 'hatc_login_plugin' ), 
		'hatc_login_text_field_2_render', 
		'pluginPage', 
		'ic_pluginPage_section' 
	);

}

// Checkbox for hide WooCommerce add to cart
function hatc_login_checkbox_field_0_render() { 

	$options = get_option( 'ic_settings' );
	?>
	<input type='checkbox' name='ic_settings[hatc_login_checkbox_field_0]' <?php if(isset($options['hatc_login_checkbox_field_0'])) { checked( $options['hatc_login_checkbox_field_0'], 1 ); } ?> value='1'>
	<label><?php _e('Check to hide add to cart buttons for guest costumers','hatc_login_plugin') ?></label>
	<?php

}


function hatc_login_text_field_0_render() { 
	
	$default_message = __('Login to see add to cart','hatc_login_plugin');

	$options = get_option( 'ic_settings' );
	?>
	<input type='text' class='regular-text' name='ic_settings[hatc_login_text_field_0]' value='<?php if(isset($options['hatc_login_text_field_0'])) { echo $options['hatc_login_text_field_0']; } ?>' placeholder='<?php echo $default_message; ?>'>
	<?php

}

function hatc_login_text_field_1_render() { 

	$options = get_option( 'ic_settings' );
	
	$myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );
	$myaccount_page_url = get_permalink( $myaccount_page_id );
	
	?>
	<input type='text' class='regular-text' name='ic_settings[hatc_login_text_field_1]' value='<?php if(isset($options['hatc_login_text_field_1'])) { echo $options['hatc_login_text_field_1']; } ?>' placeholder='<?php echo $myaccount_page_url; ?>'>
	<?php

}


// Checkbox for hide prices in WooCommerce
function hatc_login_checkbox_field_3_render() { 

	$options = get_option( 'ic_settings' );
	?>
	<input type='checkbox' name='ic_settings[hatc_login_checkbox_field_3]' <?php if(isset($options['hatc_login_checkbox_field_3'])) { checked( $options['hatc_login_checkbox_field_3'], 1 ); } ?> value='1'>
	<label><?php _e('Check to hide prices for guest costumers','hatc_login_plugin') ?></label>
	<?php

}

function hatc_login_text_field_2_render() { 

	$options = get_option( 'ic_settings' );
	?>
	<input type='text' class='regular-text' name='ic_settings[hatc_login_text_field_2]' value='<?php if(isset($options['hatc_login_text_field_2'])) { echo $options['hatc_login_text_field_2']; } ?>' placeholder='Login to see prices'>
	<?php

}


function hatc_login_settings_section_callback() { 

	echo __( 'Check the following options to hide add to cart buttons and prices for guests customers', 'hatc_login_plugin' );

}


function hatc_login_options_page() { 

 // check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
 
    // Add error/update messages
 
    // check if the user have submitted the settings
    // wordpress will add the "settings-updated" $_GET parameter to the url
    if (isset($_GET['settings-updated'])) {
        // add settings saved message with the class of "updated"
        add_settings_error('hatc_login_messages', 'hatc_login_message', __('Settings Saved', 'hatc_login_plugin'), 'updated');
    }
 
    // Show error/update messages
    settings_errors('hatc_login_messages');


	?>
	<form action='options.php' method='post'>

		<h2>Login to see add to cart and prices in WooCommerce</h2>

		<?php
		settings_fields( 'pluginPage' );
		do_settings_sections( 'pluginPage' );
		submit_button();
		?>

	</form>
	<?php
}

// Footer admin custom text 

function hatc_login_footer_admin_text () {
	
$text = sprintf( __( 'Thank you for creating with <a href="%s">WordPress</a>.' ), __( 'https://wordpress.org/' ) );	

$custom_footer_text = __('Thanks for using <b>Login to see add to cart and prices in WooCommerce</b>','hatc_login_plugin');
	
	return $text . ' | ' . $custom_footer_text;

}

add_filter('admin_footer_text', 'hatc_login_footer_admin_text');
