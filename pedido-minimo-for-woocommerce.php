<?php
/*
 * Plugin Name: Minimum order for WooCommerce
 * Description: Set a minimum order amount in your WooCommerce shop.
 * Version: 1.0.7
 * Requires Plugins: woocommerce
 * Author: Marketing Paradise
 * Author URI: https://mkparadise.com/
 * License: GPLv2 or later
 * Text Domain: pedido-minimo-for-woocommerce
 * Domain Path: /languages

 * @link      https://mkparadise.com/
 * @package   Pedido_Minimo_Woocommerce
 */

if (!defined('ABSPATH')) {
    exit;
}


/**
 * When activating the plugin, we check whether WooCommerce is active.
 */
function pedidominimo_activar_plugin_pedido_minimo() {
    if ( ! class_exists( 'WooCommerce' ) ) {
        deactivate_plugins( plugin_basename( __FILE__ ) );
        wp_die(
            esc_html__( 'We are sorry, but the "minimum order" plugin requires WooCommerce to be installed and active. Please activate WooCommerce and try again.', 'pedido-minimo-for-woocommerce' ),
            esc_html__( 'Activation error', 'pedido-minimo-for-woocommerce' ),
            array( 'back_link' => true )
        );
    }
}
register_activation_hook( __FILE__, 'pedidominimo_activar_plugin_pedido_minimo' );

final class PedidoMinimo_Principal {

    public function __construct() {
        $this->cargar_dependencias();
        new PedidoMinimo_Admin();
        new PedidoMinimo_Public();
    }

    private function cargar_dependencias() {
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-pedido-minimo-admin.php';
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-pedido-minimo-public.php';
    }
}

/**
 * Display message if we deactivate WooCommerce
 */
function pedidominimo_inicializar_plugin_pedido_minimo() {
    
    if ( ! class_exists( 'WooCommerce' ) ) {
        add_action( 'admin_notices', 'pedidominimo_aviso_falta_woocommerce' );
        return;
    }

    new PedidoMinimo_Principal();
}
add_action( 'plugins_loaded', 'pedidominimo_inicializar_plugin_pedido_minimo' );

// If WooCommerce is not active, we will launch a warning.
function pedidominimo_aviso_falta_woocommerce() {
    ?>
    <div class="notice notice-error is-dismissible">
        <p>
            <strong><?php esc_html_e( 'Minimum order for WooCommerce:', 'pedido-minimo-for-woocommerce' ); ?></strong>
            <?php esc_html_e( 'This plugin requires WooCommerce to be installed and active in order to work.', 'pedido-minimo-for-woocommerce' ); ?>
        </p>
    </div>
    <?php
}
