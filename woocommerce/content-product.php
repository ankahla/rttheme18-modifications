<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop, $products, $woo_product_layout, $page_product_count, $first_row, $last_row; 


$first_row = isset( $first_row ) ? $first_row : "first-row" ;
$last_row = isset( $last_row ) ? $last_row : "";



// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
	$woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ){

	$woo_product_layout = get_option(RT_THEMESLUG."_woo_product_layout");
	$woo_product_layout = $woo_product_layout ? $woo_product_layout : 3; //default 3 	

	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', $woo_product_layout );
}



// Ensure visibility
if ( ! $product || ! $product->is_visible() ) {
	return;
}

// Increase loop count
$woocommerce_loop['loop']++;



// Extra post classes
$classes = array();
if ( 0 === ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 === $woocommerce_loop['columns'] ) {
	$classes[] = 'first';
	$first_row = $first_row == "first-row" && $woocommerce_loop['loop'] != 1 ? "" : $first_row; //add first row clas to boxes  
	$last_row = $page_product_count - $woocommerce_loop['loop'] < $woocommerce_loop['columns'] ? "last-row" : ""; //add last row clas to boxes 
}

if ( 0 === $woocommerce_loop['loop'] % $woocommerce_loop['columns'] || $page_product_count == $woocommerce_loop['loop'] ){
	$classes[] = 'last';
}

$classes[] =  $first_row;
$classes[] =  $last_row;


/*
*	add rt class namems
*/
$woo_layout_names = array("5"=>"five","4"=>"four","3"=>"three","2"=>"two","1"=>"one");
$woo_column_class_name = "box ". $woo_layout_names[$woocommerce_loop['columns']];
$classes[] = $woo_column_class_name;


//open row block 
if(  $woocommerce_loop['loop'] % $woocommerce_loop['columns'] == 1 || $woocommerce_loop['columns'] == 1 ){
	echo '<div class="row with_borders fluid clearfix">';
}	

?>

<div <?php post_class( $classes ); ?> data-rt-animate="animate" data-rt-animation-type="fadeIn">

	<div class="product_item_holder">
		<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

			<?php
				/**
				 * woocommerce_before_shop_loop_item_title hook
				 *
				 * @hooked woocommerce_show_product_loop_sale_flash - 10
				 * @hooked woocommerce_template_loop_product_thumbnail - 10
				 */
				do_action( 'woocommerce_before_shop_loop_item_title' );
			?>

			<div class="product_info">


				<?php
					/**
					 * woocommerce_shop_loop_item_title hook
					 *
					 * @hooked woocommerce_template_loop_product_title - 10
					 */
					do_action( 'woocommerce_shop_loop_item_title' );
				?>				
					

				<?php
					/**
					 * woocommerce_after_shop_loop_item_title hook
					 *
					 * @hooked woocommerce_template_loop_price - 10
					 */
					do_action( 'woocommerce_after_shop_loop_item_title' );
				?>

			</div> 

	<?php

		/**
		 * woocommerce_after_shop_loop_item hook
		 *
		 * @hooked woocommerce_template_loop_add_to_cart - 10
		 */
		do_action( 'woocommerce_after_shop_loop_item' ); 

	?>
			
	</div>

</div>


<?php
//close row block 
if( $woocommerce_loop['loop'] % $woocommerce_loop['columns'] == 0 || $page_product_count == $woocommerce_loop['loop'] ){
	echo '</div>';  
}?>
