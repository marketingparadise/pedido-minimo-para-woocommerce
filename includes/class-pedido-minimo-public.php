<?php
/**
 * The frontend functionality of the plugin.
 *
 * @package    Pedido_Minimo_Woocommerce
 * @subpackage Pedido_Minimo_Woocommerce/frontend
 * @author     Marketing Paradise <rafael@mkparadise.com>
 */

if (!defined('ABSPATH')) {
    exit;
}

class PedidoMinimo_Public {
    public function __construct()
    {
        add_action( 'woocommerce_check_cart_items' , array($this, 'woocommerce_importe_minimo') );
    }

     /**
      * Set a minimum purchase amount
      */
    public function woocommerce_importe_minimo() {
        $minimum = get_option( 'pedidominimo_precio_minimo', 0 );  // Value of the options page
        $incluir_descuentos = get_option( 'pedidominimo_incluir_descuentos', '0' ); // Value of the options page
        $mensaje = get_option('pedidominimo_mensaje_pedido_minimo');

        if ($minimum <= 0 || ! WC()->cart ) {
            return;
        }
        if ($incluir_descuentos) {
            $subtotal_a_validar  = WC()->cart->get_cart_contents_total();
        } else {
            $subtotal_a_validar  = WC()->cart->get_subtotal();
        }
        if ( $subtotal_a_validar < $minimum ) {
    
            $mensaje = str_replace(
                array( '{minimum}', '{total}' ), // Placeholders
                array( wc_price( $minimum ), wc_price( $subtotal_a_validar ) ),
                $mensaje
            );
            
            wc_add_notice( $mensaje, 'error' );
        }
    }
}