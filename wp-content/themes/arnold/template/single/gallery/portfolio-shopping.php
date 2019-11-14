<?php
$shopping_select_product = arnold_get_post_meta(get_the_ID(), 'theme_meta_shopping_select_product');

if($shopping_select_product){
	$get_post = get_post($shopping_select_product);
	
	if(function_exists('wc_get_product')){
		$GLOBALS['product'] = wc_get_product($get_post);
		
		//echo $product->get_price_html();
		
		if(function_exists('woocommerce_template_single_add_to_cart')){
			woocommerce_template_single_add_to_cart();
		}
	
	}
}

?>