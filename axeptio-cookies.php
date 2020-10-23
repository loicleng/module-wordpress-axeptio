<?php
/*
  Plugin Name: Axeptio Cookies
  Plugin URI: https://wordpress.org/plugins/axeptio-cookies/
  Description: Axeptio cookies integration
  Author: Dectys (Florian)
  Author URI: https://dectys.com/
  Version: 1.0.0
  License:           GPL v2 or later
  License URI:       https://www.gnu.org/licenses/gpl-2.0.html
  Requires PHP:      7.0
  Axeptio Cookies is free software: you can redistribute it and/or modify
*/

defined( 'ABSPATH' ) or die( 'Hack me not' );

define( 'AXEPTIO_FILE'            	, __FILE__ );
define( 'AXEPTIO_PATH'       		, realpath( plugin_dir_path( AXEPTIO_FILE ) ) . '/' );
/*
if(is_user_admin()) {
	require(AXEPTIO_PATH . '/inc/admin.php');
}
*/

if ( is_admin() ) {
	// we are in admin mode
	//require_once __DIR__ . '/admin/plugin-name-admin.php';
	require_once __DIR__ . '/inc/admin.php';
}

/* Inline script printed out in the footer */
add_action('wp_footer', 'axeptio_dectys_add_script_wp_footer');
function axeptio_dectys_add_script_wp_footer() {

    if(get_option( 'axeptioVersion' ) && get_option( 'axeptioIdKey' )) {
    ?>
        <script type="text/javascript">
            var el = document.createElement('script');
            el.setAttribute('src', 'https://static.axept.io/sdk.js');
            el.setAttribute('type', 'text/javascript');
            el.setAttribute('async', true);
            el.setAttribute('data-id', '<?php echo get_option( "axeptioIdKey" ); ?>');
            el.setAttribute('data-cookies-version', '<?php echo get_option( "axeptioVersion" ); ?>');
            if (document.body !== null) {
                document.body.appendChild(el);
            }
        </script>
    <?php
    } else {
	    ?>
        <script type="text/javascript">
            console.log("Axeptio : no id key or no version")
        </script>
	    <?php
    }
}
