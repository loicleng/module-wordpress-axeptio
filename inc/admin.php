<?php
defined( 'ABSPATH' ) or die( 'Hack me not' );

add_action( 'admin_menu', 'axeptio_settings' );
function axeptio_settings() {
	add_options_page(
		"axeptio-cookies",
		"axeptio-cookies",
		'manage_options',
		"axeptio-cookies",
		'axeptio_config_page' );
}

function axeptio_config_page() {
	if ( isset( $_POST['updated'] ) && $_POST['updated'] === 'true' ) {
		axeptio_handle_form();
	}
	echo axeptio_display_form();
}

function axeptio_display_form() {
	return '<div class="wrap">
                <div class="axeptioIntroduction">
                	<h3><svg viewBox="0 0 24 24" style="display: inline; width: 24px; vertical-align: middle;"><path fill="rgb(255, 200, 35)" d="M21.662 2.821C18.866.025 11.663-.252 5.124 5.422-.987 10.725-.89 17.107 3.87 20.613c4.443 3.272 10.542 3.802 15.191-1.256 5.648-6.144 5.399-13.74 2.601-16.536z"></path><path fill="#FFF" d="M8.104 14.644a.567.567 0 01-.804 0h-.001l-2.53-2.529a.57.57 0 01.805-.807l2.128 2.127 6.186-6.185a.57.57 0 01.805.805l-6.589 6.589zm4.895-1.92a.546.546 0 01-.387-.93l4.047-4.047a.549.549 0 01.774 0 .549.549 0 010 .774l-4.046 4.047a.545.545 0 01-.388.156zm4.964 1.236l-1.593 1.591a.544.544 0 01-.773 0 .549.549 0 010-.774l1.594-1.594a.547.547 0 11.79.755l-.016.017-.002.005zm0-2.985l-3.085 3.084a.549.549 0 01-.774-.775l3.087-3.087a.549.549 0 01.774.775l-.002.003z"></path></svg> 
                	' . __( 'Axeptio - Cookies and personal data management', 'axeptio-cookies' ) . '
                	</h3>
	                <p>' . __( 'The informations needed to configure this module are on your admin panel on', 'axeptio-cookies' ) . ' <a href="https://admin.axeptio.eu/" target="_blank">admin.axeptio.eu</a>
                        <br />
                        ' . __( 'Find your version ID and key to input on the form below', 'axeptio-cookies' ) . '
                        <br />
                        ' . __( 'Technical documentation', 'axeptio-cookies' ) . ' : <a href="https://developers.axeptio.eu/integration/integration-cms/integration-wordpress" target="_blank">https://developers.axeptio.eu/integration/integration-cms/integration-wordpress</a>
                    </p>
                </div>
		
            <form method="post" action="">
                <div class="axeptioDiv">
                    <input type="hidden" name="updated" value="true" />
    			    ' . wp_nonce_field( 'axeptio_update', 'axeptio_form' ) . '
                    <label>
                        ' . __( 'ID Key', 'axeptio-cookies' ) . '
                        <br />
                        <input type="text" name="axeptioIdKey" value="' . get_option( 'axeptioIdKey' ) . '"/>
                    </label>
                    <label>
                        ' . __( 'Version', 'axeptio-cookies' ) . '
                        <br />
                        <input type="text" name="axeptioVersion" value="' . get_option( 'axeptioVersion' ) . '"/>
                    </label>
                    
                    <input class="button button-primary" type="submit" value="' . __( 'Save', 'axeptio-cookies' ) . '" />
                </div>
			</form>
        </div>
        
        <style type="text/css">
            .axeptioDiv,
            .axeptioIntroduction {
                max-width: 800px;
                padding: 20px;
            }

            .axeptioDiv {

                background: #FFF;
                border: 1px solid #eee;
                border-bottom: 2px solid #ddd;
            }

            .axeptioIntroduction {
                background: #F6FFFF;
                border: 1px solid #188DC5;
                border-radius: 5px;
                margin: 25px 0;
                font-size: 17px;
                line-height: 25px;
            }

            .axeptioDiv label {
                display: block;
                margin: 0 0 20px;
            }

            .axeptioDiv input {
                border: 1px solid #aaa;
                background: #F7F7F7;
            }

            .axeptioDiv input[type=text] {
            }

            .axeptioDiv input[type=submit] {
                font-size: 18px;
            }

            .ax_error, .ax_success {
                margin: 10px 0px;
                padding: 4px 20px;
                border: 1px solid transparent;
                border-left-width: 4px;
                max-width: 800px;
            }

            .ax_error p, .ax_success p {
                margin: 3px 0;
                padding: 2px;
            }

            .ax_success {
                color: #4F8A10;
                background-color: #DFF2BF;
                border-left-color: #4F8A10;
            }

            .ax_error {
                color: #dc3232;
                background-color: #FFD2D2;

                border-left-color: #dc3232;
            }
        </style>
        '
        ;
}

function axeptio_handle_form() {
	if (
		! isset( $_POST['axeptio_form'] ) ||
		! wp_verify_nonce( $_POST['axeptio_form'], 'axeptio_update' )
	) { ?>
        <div class="error">
            <p><?php echo __( 'Sorry, an error occured. Please try again. Contact us if the problem persist.', 'axeptio-cookies' ); ?></p>
        </div> <?php
		exit;
	} else {
		// Handle our form data
		if ( isset( $_POST['axeptioIdKey'] ) and isset( $_POST['axeptioVersion'] ) ) {
			update_option( 'axeptioIdKey', sanitize_text_field( $_POST['axeptioIdKey'] ) );
			update_option( 'axeptioVersion', sanitize_text_field( $_POST['axeptioVersion'] ) );
			?>

            <div class="ax_success">
                <p><?php echo __( 'Your settings were saved', 'axeptio-cookies' ); ?></p>
            </div>
			<?php
		} else {
			?>
            <div class="ax_error">
                <p><?php echo __( 'Sorry, your settings were not saved', 'axeptio-cookies' ); ?></p>
            </div>
			<?php
		}
	}
}