<?php
/**
 * The plugin's administration functionality.
 *
 * @package    Pedido_Minimo_Woocommerce
 * @subpackage Pedido_Minimo_Woocommerce/admin
 * @author     Marketing Paradise <rafael@mkparadise.com>
 */

if (!defined('ABSPATH')) {
    exit;
}

class PedidoMinimo_Admin {

    public function __construct() {
        add_action('admin_menu', array($this, 'menu_pedido_minimo')); // Add page to WooCommerce submenu
        add_action('admin_init', array ($this, 'crear_settings')); // We create settings sections, register settings, and create fields.
    }

    /**
     * Add page to WooCommerce submenu
     */
    public function menu_pedido_minimo() {
        add_submenu_page(
            'woocommerce',
            esc_html__( 'Minimum order', 'pedido-minimo-for-woocommerce' ),
            esc_html__( 'Set minimum order', 'pedido-minimo-for-woocommerce' ),
            'manage_woocommerce',
            'mkp-opciones-pedidominimo',
            array ($this, 'opciones_pedidominimo_callback'),
            7
        );
    }

    public function opciones_pedidominimo_callback() {
        ?>
		    <div class="wrap">
                <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			    <form method="post" action="options.php">
				    <?php
                    settings_errors(); // Errors. We do not set “pedidominimo_settings_error” so that all errors are displayed, not just those we configure.
					settings_fields( 'pedidominimo_pedidominimo_settings_group' ); // Name of the settings group
					do_settings_sections( 'mkp-opciones-pedidominimo' ); // page slug of the options page
					submit_button(); // Button that saves the options
				    ?>
			    </form>
		    </div>
	    <?php
    }

    /**
     * We create settings sections, register settings, and create fields.
     */
    public function crear_settings() {

        $page_slug = 'mkp-opciones-pedidominimo';
	    $option_group = 'pedidominimo_pedidominimo_settings_group';

        // 1 - We create the section
        add_settings_section(
	        'pedidominimo_pedidominimo_seccion', // Section ID
	        esc_html__( 'Options', 'pedido-minimo-for-woocommerce' ), // title (optional)
	        '', // callback to paint the section (optional)
	        $page_slug
	    );

        // 2 - We register the fields
        register_setting($option_group, 'pedidominimo_precio_minimo', array ($this, 'validar_precio'));
        register_setting($option_group, 'pedidominimo_incluir_descuentos', array($this, 'validar_checkbox'));
        register_setting($option_group, 'pedidominimo_mensaje_pedido_minimo', array($this, 'validar_textarea'));

        // 3 - We add the fields
        add_settings_field(
            'pedidominimo_precio_minimo',
            esc_html__( 'Amount', 'pedido-minimo-for-woocommerce' ),
            array ($this, 'pinta_precio_minimo'), // function that paints the field
            $page_slug,
            'pedidominimo_pedidominimo_seccion' // Section ID
        );

        add_settings_field(
            'pedidominimo_incluir_descuentos',
            esc_html__( 'Include discounts?', 'pedido-minimo-for-woocommerce' ),
            array ($this, 'pinta_incluir_descuentos'), // function that paints the field
            $page_slug,
            'pedidominimo_pedidominimo_seccion' // Section ID
        );

        add_settings_field(
        'pedidominimo_mensaje_pedido_minimo',
        esc_html__( 'Alert message', 'pedido-minimo-for-woocommerce'),
        array ($this, 'pinta_mensaje_pedido_minimo'), // function that paints the field
        $page_slug, // Slug de la página de ajustes
        'pedidominimo_pedidominimo_seccion' // Section ID
        );
    }

    // 4 - We paint the fields
    public function pinta_precio_minimo () {
        $pedidominimo = get_option('pedidominimo_precio_minimo', 0);
        echo "<input id='mkp-valor-pedidominimo' name='pedidominimo_precio_minimo' type='text' value='". esc_attr( $pedidominimo ) ."' />";
    }

    public function pinta_incluir_descuentos() {
        $opcion = get_option('pedidominimo_incluir_descuentos');
        echo "<input id='mkp-incluir-descuentos' name='pedidominimo_incluir_descuentos' type='checkbox' value='1' " . checked(1, $opcion, false) . " />";
        echo '<label for="mkp-incluir-descuentos" class="mkp-description">' . esc_html(__('Check this box if you want the minimum order amount to be verified after applying the coupon discount.', 'pedido-minimo-for-woocommerce')) . '</label>';
    }

    public function pinta_mensaje_pedido_minimo () {
        $mensaje_actual = get_option('pedidominimo_mensaje_pedido_minimo');

        // Default message
        /* translators: {minimum}: minimum price value that the cart subtotal must reach, {total}: the current cart subtotal. */
        $mensaje_defecto = __('You must place a <strong>minimum order of {minimum}</strong> to complete your purchase. Your cart total is currently {total}.', 'pedido-minimo-for-woocommerce');
    
        if (empty($mensaje_actual)) {
            $mensaje_actual = $mensaje_defecto;
        }

        echo '<textarea id="mkp_mensaje_pedido_minimo_id" 
                          name="pedidominimo_mensaje_pedido_minimo" 
                          rows="4" 
                          cols="80">' . esc_textarea($mensaje_actual) . '</textarea>';
        /* translators: {minimum}: minimum price value that the cart subtotal must reach, {total}: the current cart subtotal. */
        echo '<p class="description">' . esc_html(__('Use {minimum} for the minimum amount and {total} for the current cart total.', 'pedido-minimo-for-woocommerce')) . '</p>';

    }

    // Fields validation
    public function validar_precio ($input) {
        if (!is_numeric($input) || $input < 0) { // The minimum order must be a number greater than zero.
            add_settings_error(
		    'pedidominimo_settings_error',
		    'no-float', // part of the error message ID id="setting-error-no-float"
		    esc_html__('The amount is invalid', 'pedido-minimo-for-woocommerce'), // Error message
		    'error' // error type
	    );
        $input = get_option('pedidominimo_precio_minimo', 0); // If there is an error, the previous value remains.
    }

    $input_sanitizado = floatval($input);
    return $input_sanitizado;
    }

    public function validar_checkbox($input) {
        return isset($input) && $input == '1' ? '1' : '0';
    }

    public function validar_textarea ($input) {

        // html tags allowed
        $allowed_html = [
            'strong' => [],
            'em'     => [],
            'b'      => [],
            'i'      => [],
            'span'   => [
                'class' => [],
                'style' => [],
            ],
        ];

        $sanitized_input = wp_kses( $input, $allowed_html );

        return $sanitized_input;

    }
}