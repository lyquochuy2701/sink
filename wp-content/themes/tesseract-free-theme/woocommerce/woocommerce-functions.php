<?php



global $layout_loop;

global $layout_product;

global $isloop;

$layout_loop = (get_theme_mod('tesseract_woocommerce_loop_layout')) ? get_theme_mod('tesseract_woocommerce_loop_layout') : 'four-column';

$isloop = ( function_exists( 'WC' ) && (is_shop() || is_product_category() || is_product_tag()) ) ? true : false;



// Basic integration config

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);

remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);



add_action('woocommerce_before_main_content', 'tesseract_woocommerce_wrapper_start', 10);

add_action('woocommerce_after_main_content', 'tesseract_woocommerce_wrapper_end', 10);



function tesseract_woocommerce_wrapper_start() {



	$layout_loop = (get_theme_mod('tesseract_woocommerce_loop_layout')) ? get_theme_mod('tesseract_woocommerce_loop_layout') : 'four-column';

	$layout_product = get_theme_mod('tesseract_woocommerce_product_layout');



	if ( function_exists( 'WC' ) && (is_shop() || is_product_category() || is_product_tag()) ) {

		if ( ( $layout_loop == 'sidebar-left' ) || ( !$layout_loop ) ) {

			$primclass = 'with-sidebar sidebar-left';

		} else if ( ( $layout_loop == 'sidebar-right' ) || ( !$layout_loop ) ) {

			$primclass = 'with-sidebar sidebar-right';

		} else if ( ( $layout_loop == 'one-columnlistleft' ) || ( !$layout_loop ) ) {

			$primclass = 'with-sidebar onecolumnlist columnlistleft';

		} else if ( ( $layout_loop == 'one-columnlistright' ) || ( !$layout_loop ) ) {

			$primclass = 'with-sidebar onecolumnlist columnlistright';

		} else if ( ( $layout_loop == 'two-columnlistleft' ) || ( !$layout_loop ) ) {

			$primclass = 'with-sidebar twocolumnlist columnlistleft';

		} else if ( ( $layout_loop == 'two-columnlistright' ) || ( !$layout_loop ) ) {

			$primclass = 'with-sidebar twocolumnlist columnlistright';

		} else if ( ( $layout_loop == 'three-columnlistleft' ) || ( !$layout_loop ) ) {

			$primclass = 'with-sidebar threecolumn columnlistleft';

		} else if ( ( $layout_loop == 'three-columnlistright' ) || ( !$layout_loop ) ) {

			$primclass = 'with-sidebar threecolumn columnlistright';

		} else if ( ( $layout_loop == 'four-columnlistleft' ) || ( !$layout_loop ) ) {

			$primclass = 'with-sidebar fourcolumn columnlistleft';

        } else if ( ( $layout_loop == 'four-columnlistright' ) || ( !$layout_loop ) ) {

			$primclass = 'with-sidebar fourcolumn columnlistright';

		} else if ( ( $layout_loop == 'five-columnlistleft' ) || ( !$layout_loop ) ) {

			$primclass = 'with-sidebar fivecolumn columnlistleft';

		} else if ( ( $layout_loop == 'five-columnlistright' ) || ( !$layout_loop ) ) {

			$primclass = 'with-sidebar fivecolumn columnlistright';	

		} else if ( ( $layout_loop == 'fullwidth' ) || ( !$layout_loop ) ) {

			$primclass = 'no-sidebar';

		} else if ( ( $layout_loop == 'one-columnlist' ) || ( !$layout_loop ) ) {

			$primclass = 'onecolumnlist';

		} else if ( ( $layout_loop == 'two-columnlist' ) || ( !$layout_loop ) ) {

			$primclass = 'twocolumnlist';	

		} else if ( ( $layout_loop == 'three-column' ) || ( !$layout_loop ) ) {

			$primclass = 'threecolumn';

		} else if ( ( $layout_loop == 'four-column' ) || ( !$layout_loop ) ) {

			$primclass = 'fourcolumn';

		} else if ( ( $layout_loop == 'five-column' ) || ( !$layout_loop ) ) {

			$primclass = 'fivecolumn';

		}	

	} else if ( is_product() ) {

		if ( ( $layout_product == 'sidebar-left' ) || ( $layout_product == 'sidebar-right' ) ) {

			$primclass = 'with-sidebar';

			$primclass .= ( $layout_product == 'sidebar-left' ) ? ' sidebar-left' : ' sidebar-right';

		} else if ( ( $layout_product == 'fullwidth' ) || ( !$layout_product ) ) {

			$primclass = 'no-sidebar';

		}

	} else { $primclass = 'sidebar-default'; }



  echo '<div id="primary" class="content-area woo-cont ' . $primclass . '">';



}



// Update number of columns on shop/pr. category/pr. tag pages when a layout with sidebar is active

function tesseract_woocommerce_wrapper_end() {

  echo '</div>';

}



/*if ( ( !function_exists('loop_shop_columns') ) &&

   ( ( $layout_loop == 'sidebar-left' ) || ( $layout_loop == 'sidebar-right' ) ) ) {



		// Change number or products per row to 2

		add_filter('loop_shop_columns', 'tesseract_loop_columns');



		function tesseract_loop_columns() {

			return 2; // 3 products per row

		}



}*/





// Ensure cart contents update when products are added to the cart via AJAX

add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );



function woocommerce_header_add_to_cart_fragment( $fragments ) {

	ob_start();

	?>

    <div class="woocart-header">

        <a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>">

        	<span class="dashicons dashicons-arrow-down cart-arrow"></span>

            <span class="cart-contents-counter"><?php echo WC()->cart->cart_contents_count; ?></span>

            <span class="icon-shopping-cart"></span>

        </a>

        <div class="cart-content-details-wrap">

            <div class="cart-content-details">

                <?php if ( WC()->cart->cart_contents_count == 0 ) : ?>

                    <span>Your Shopping Cart is empty.</span>

                <?php else: ?>

                    <table class="cart-content-details-table">

                        <thead>

                            <tr>

                                <th>Product Name</th>

                                <th>Quantity</th>

                                <th class="right">Price</th>

                            </tr>

                        </thead>

                        <tfoot>

                            <td></td>

                            <td><?php echo WC()->cart->cart_contents_count; ?></td>

                            <td class="right"><?php echo WC()->cart->get_cart_total(); ?></td>

                        </tfoot>

                        <tbody>

                            <?php foreach( WC()->cart->cart_contents as $product ):

                                echo '<tr>';

                                echo '<td>' . $product['data']->post->post_name . '</td>';

                                echo '<td>' . $product['quantity'] . '</td>';

                                echo '<td class="right">' . intval($product['quantity']) * intval($product['data']->price) . get_woocommerce_currency() . '</td>';

                                echo '</tr>';

                            endforeach; ?>

                        </tbody>

                    </table>

                <?php endif; ?>

                <a href="<?php echo WC()->cart->get_cart_url(); ?>">View Cart (<?php echo WC()->cart->cart_contents_count; ?> Items)</a>

            </div>

        </div>

  	</div>

	<?php



	$fragments['.woocart-header'] = ob_get_clean();



	return $fragments;

}



// Output shopping cart in header

function tesseract_wc_output_cart() {

	ob_start(); ?>

	<div class="woocart-header">

        <a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>">

        	<span class="dashicons dashicons-arrow-down cart-arrow"></span>

            <span class="cart-contents-counter"><?php echo WC()->cart->cart_contents_count; ?></span>

            <span class="icon-shopping-cart"></span>

        </a>

        <div class="cart-content-details-wrap">

            <div class="cart-content-details">

                <?php if ( WC()->cart->cart_contents_count == 0 ) : ?>

                    <span>Your Shopping Cart is empty.</span>

                <?php else: ?>

                    <table class="cart-content-details-table">

                        <thead>

                            <tr>

                                <th>Product Name</th>

                                <th>Quantity</th>

                                <th class="right">Price</th>

                            </tr>

                        </thead>

                        <tfoot>

                            <td></td>

                            <td><?php echo WC()->cart->cart_contents_count; ?></td>

                            <td class="right"><?php echo WC()->cart->get_cart_total(); ?></td>

                        </tfoot>

                        <tbody>

                            <?php foreach( WC()->cart->cart_contents as $product ):

                                echo '<tr>';

                                echo '<td>' . $product['data']->post->post_name . '</td>';

                                echo '<td>' . $product['quantity'] . '</td>';

                                echo '<td class="right">' . intval($product['quantity']) * intval($product['data']->price) . get_woocommerce_currency() . '</td>';

                                echo '</tr>';

                            endforeach; ?>

                        </tbody>

                    </table>

                <?php endif; ?>

                <a href="<?php echo WC()->cart->get_cart_url(); ?>">View Cart (<?php echo WC()->cart->cart_contents_count; ?> Items)</a>

            </div>

        </div>

	</div>

    <?php $output = ob_get_contents();

    ob_end_clean();



    echo $output;

}



//Get Woocommerce version number

function tesseract_wc_version_number() {

        // If get_plugins() isn't available, require it

	if ( ! function_exists( 'get_plugins' ) )

		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );



        // Create the plugins folder and file variables

	$plugin_folder = get_plugins( '/' . 'woocommerce' );

	$plugin_file = 'woocommerce.php';



	// If the plugin version number is set, return it

	if ( isset( $plugin_folder[$plugin_file]['Version'] ) ) {

		return $plugin_folder[$plugin_file]['Version'];



	} else {

	// Otherwise return null

		return NULL;

	}

}



/*

 * WOOCOMMERCE CUSTOMIZER ADDITIONS -----------------------------------------------------------------------------

 */



// Sanitize functions



function tesseract_sanitize_select_woocommerce_layout_types( $value ) {



	if ( ! in_array( $value, array( 'sidebar-left', 'sidebar-right', 'fullwidth', 'one-columnlist', 'one-columnlistleft', 'one-columnlistright', 'two-columnlist', 'two-columnlistleft', 'two-columnlistright', 'three-column', 'three-columnlistleft', 'three-columnlistright', 'four-column', 'four-columnlistleft', 'four-columnlistright', 'five-column', 'five-columnlistleft', 'five-columnlistright', ) ) ) :

        $value = 'one-columnlist';

	endif;



    return $value;



}



/*

 * EOF woocommerce customizer additions -----------------------------------------------------------------------------

 */



//Woo header cart styles based on the selected Tesseract header size

function tesseract_woocommerce_headercart_scripts() {



	// Enqueue WooCommerce style

	wp_enqueue_style( 'woocommerce-style', get_template_directory_uri() . '/woocommerce/assets/css/woocommerce-style.css', array('tesseract-style'), '1.0.0' );

	wp_enqueue_script( 'tesseract-woocommerce_helpers', get_template_directory_uri() . '/woocommerce/assets/js/woocommerce-helpers.js', array( 'jquery' ), '1.0.0', true );



	// Detailed Cart Content Background

	$header_bckRGB = get_theme_mod('tesseract_header_colors_bck_color') ? get_theme_mod('tesseract_header_colors_bck_color') : '#53a9db';



	// Cart Borders

	$cart_topBorderColor = get_theme_mod('tesseract_header_colors_text_color') ? get_theme_mod('tesseract_header_colors_text_color') : '#ffffff';



	$dynamic_styles_woo_header = ".cart-content-details-table tfoot td {

		border-top: " . $cart_topBorderColor . " solid 1px;

	}



	.cart-content-details {

		background: " . $header_bckRGB . ";

		}



	.cart-content-details:after { border-bottom-color: " . $header_bckRGB . "; }

	";



	wp_add_inline_style( 'tesseract-site-banner', $dynamic_styles_woo_header );



}

add_action( 'wp_enqueue_scripts', 'tesseract_woocommerce_headercart_scripts' );



function tesseract_woocommerce_customize_controls_style() {

	wp_enqueue_style( 'tesseract_woocommerce_customize_controls_style', get_template_directory_uri() . '/woocommerce/assets/css/woocommerce-customize-controls.css' );

}



add_action( 'customize_controls_print_styles', 'tesseract_woocommerce_customize_controls_style' );



$args = array(  
		        'post_type' => 'product',  
		        'posts_per_page' => -1,
		        'post_status' => 'publish'
		    );  
$pr = get_posts($args); 



add_filter( 'loop_shop_per_page', function ( $cols ) {
    $pr_per_page = (get_theme_mod('tesseract_product_per_page')) ? get_theme_mod('tesseract_product_per_page') : 12; //floor(count($pr)/2);
    //echo '--------------->'.$pr_per_page;
    return $pr_per_page;
}, 20 );