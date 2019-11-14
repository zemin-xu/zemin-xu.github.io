<?php
//Function interface ajax search list
function arnold_interface_ajax_search_list(){
	$data = $_POST['data'];
	$keywords = $data["keywords"];
	$paged = $data["paged"];
	arnold_interface_search_list_load($keywords, $paged);
	exit;
}
add_action('wp_ajax_arnold_interface_ajax_search_list', 'arnold_interface_ajax_search_list');
add_action('wp_ajax_nopriv_arnold_interface_ajax_search_list', 'arnold_interface_ajax_search_list');


//Function interface ajax add cart
function blocker_interface_ajax_add_cart(){
	$product_id = $_POST['product_id'];
	$quantity = empty( $_POST['quantity'] ) ? 1 : wc_stock_amount( $_POST['quantity'] );
	blocker_woocommerce_loop_add_to_cart($product_id, $quantity);

	exit;
}
add_action('wp_ajax_blocker_interface_ajax_add_cart', 'blocker_interface_ajax_add_cart');
add_action('wp_ajax_nopriv_blocker_interface_ajax_add_cart', 'blocker_interface_ajax_add_cart');

//Function interface ajax cart number
function blocker_interface_ajax_cart_number(){
	if(function_exists('WC')){
		echo sizeof(WC()->cart->get_cart());
	}

	exit;
}
add_action('wp_ajax_blocker_interface_ajax_cart_number', 'blocker_interface_ajax_cart_number');
add_action('wp_ajax_nopriv_blocker_interface_ajax_cart_number', 'blocker_interface_ajax_cart_number');

//Function interface ajax portfolio list
function arnold_interface_ajax_portfolio_list(){
	$post_id = intval($_POST['post_id']);
	$paged = intval($_POST['paged']);
	
	if($post_id){
		$category = arnold_get_option('theme_option_category_for_more_project');
		$per_page = arnold_get_option('theme_option_category_for_more_project_num');
		
		$per_page = $per_page ? intval($per_page) : -1;
		
		$paged = $paged ? $paged : 1;
		
		if(!intval($category)){
			$category = '';
		}else{
			$category = intval($category);
		}
		
		$the_query = new WP_Query(array(
			'posts_per_page' => $per_page,
			'paged' => $paged,
			'category__in' => $category,
			'tax_query' => array(
				array(
					'taxonomy' => 'post_format',
					'field' => 'slug',
					'terms' => array('post-format-gallery')
				)
			)
		));
		
		if($the_query->have_posts()){
			
			if($paged < 2){ ?>
		
			<div class="ux-portfolio-ajaxed-list-wrap container">
				<div class="ux-portfolio-ajaxed-list grid-mask-boxed-center clearfix">
                <?php } ?>
				
					<?php
					while($the_query->have_posts()){ $the_query->the_post();
						$thumb_width = 650;
						$thumb_height = 490;
						$thumb_url = get_template_directory_uri(). '/img/blank.gif';
						
						if(has_post_thumbnail()){
							$thumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'arnold-thumb-11-normal');
							$thumb_width = $thumb[1];
							$thumb_height = $thumb[2];
							$thumb_url = $thumb[0];
						}
						
						$thumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'arnold-thumb-11-normal');
						
						$image_lazyload = arnold_get_option('theme_option_enable_image_lazyload');
						$image_lazyload_img_style = 'data-bg="' .esc_url($thumb_url). '"';
						$image_lazyload_img_class = 'ux-lazyload-bgimg';
						if(!$image_lazyload){
							$image_lazyload_img_style = 'style="background-image:url(' .esc_url($thumb_url). ');"';
							$image_lazyload_img_class = '';
						}  ?>
						
                        <section class="ajaxed-grid-item grid-item">
							<div class="grid-item-inside">
								<div class="grid-item-con">
									<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="grid-item-mask-link"></a>
									<div class="grid-item-con-text">
										<h2 class="grid-item-tit"><a class="grid-item-tit-a" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
									</div>
								</div>
				
								<div class="brick-content ux-lazyload-wrap" style="padding-top:75%;">
									<div class="ux-background-img <?php echo esc_attr($image_lazyload_img_class); ?>"  <?php echo balanceTags($image_lazyload_img_style); ?>></div>
								</div>
								
							</div><!--End inside-->
						</section> 
                    <?php
                    }
					wp_reset_postdata(); 
					
				if($paged < 2){ ?>
				</div>
                
                <?php if($the_query->have_posts()){
					arnold_page_view_pagination($post_id, $the_query, 'load-more'); 
				} ?>
			</div>
			<?php
            }
		}
	}
	
	exit;
}
add_action('wp_ajax_arnold_interface_ajax_portfolio_list', 'arnold_interface_ajax_portfolio_list');
add_action('wp_ajax_nopriv_arnold_interface_ajax_portfolio_list', 'arnold_interface_ajax_portfolio_list');

//Function interface ajax page masonry list
function arnold_interface_page_ajax_masonry_list(){
	$post_id = intval($_POST['post_id']);
	$paged = intval($_POST['paged']);
	
	if($post_id){
		arnold_page_load_masonry_list($post_id, $paged);
	}
	
	exit;
}
add_action('wp_ajax_arnold_interface_page_ajax_masonry_list', 'arnold_interface_page_ajax_masonry_list');
add_action('wp_ajax_nopriv_arnold_interface_page_ajax_masonry_list', 'arnold_interface_page_ajax_masonry_list');

//Funtion interface ajax page filter
function arnold_interface_page_ajax_filter(){
	$module_post = intval($_POST['post_id']);
	$post__not_in = $_POST['post__not_in'];
	$cat_id = intval($_POST['cat_id']);
	
	if(!$post__not_in){
		$post__not_in = array();
	}
	
	if($module_post){
		$page_template = arnold_get_post_meta($module_post, 'theme_meta_page_template');
		$category = arnold_get_post_meta($module_post, 'theme_meta_page_category');
		$orderby = arnold_get_post_meta($module_post, 'theme_meta_page_orderby');
		$order = arnold_get_post_meta($module_post, 'theme_meta_order');
		$per_page = arnold_get_post_meta($module_post, 'theme_meta_page_number');
		$layout_builder = arnold_get_post_meta($module_post, 'theme_meta_page_portfolio_layout_builder');
		
		$per_page = $per_page ? $per_page : -1;
		
		if($page_template == 'masonry-grid'){
			$category = arnold_get_post_meta($module_post, 'theme_meta_page_category_masonry_grid');
			$list_layout = get_post_meta($module_post, '_portfolio_list_layout_' .intval($category), true);
		}
		$this_cat_id = $category;
		
		if($category){
			if(!is_array($category)){
				$category = array($category);
			}
		}else{
			$category = array();
		}
		
		if($cat_id){
			$category = array($cat_id);
			$get_categories = get_categories(array( 'parent' => $cat_id ));
		}else{
			$get_categories = get_categories(array( 'parent' => $this_cat_id ));
		}
		
		if($get_categories){
			foreach($get_categories as $cat){
				array_push($category, $cat->term_id);
			}
		}
		
		$get_posts = get_posts(array(
			'posts_per_page' => $per_page,
			//'paged' => $paged,
			'orderby' => $orderby,
			'order' => $order,
			'category__in' => $category,
			'post__not_in' => $post__not_in,
			'tax_query' => array(
				array(
					'taxonomy' => 'post_format',
					'field' => 'slug',
					'terms' => array('post-format-gallery', 'post-format-link'),
				)
			)
		));
		
		switch($page_template){
			case 'blog-masonry':
				$paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
				$get_posts = get_posts(array(
					'posts_per_page' => $per_page,
					'paged' => $paged,
					'orderby' => $orderby,
					'order' => $order,
					'category__in' => $category
				));
			break;
			
			case 'masonry-grid':
				$per_page = isset($_POST['per_page']) ? intval($_POST['per_page']) : $per_page;
				$get_posts = get_posts(array(
					'posts_per_page' => $per_page,
					'category__in' => $category,
					'post__not_in' => $post__not_in,
					'tax_query' => array(
						array(
							'taxonomy' => 'post_format',
							'field' => 'slug',
							'terms' => array('post-format-gallery', 'post-format-link'),
						)
					)
				));
			
				/*$list_layout = get_post_meta($module_post, '_portfolio_list_layout', true);
				$list_layout_cat = get_post_meta($module_post, '_portfolio_list_layout_cat', true);
				if(count($category) == 0 || $list_layout_cat != $this_cat_id){
					$get_posts = get_posts(array(
						'posts_per_page' => -1,
						'category__in' => $category,
						'tax_query' => array(
							array(
								'taxonomy' => 'post_format',
								'field' => 'slug',
								'terms' => array('post-format-gallery', 'post-format-link'),
							)
						)
					));
					
					if($get_posts){
						$query_layout = array();
						
						$i = 0;
						$width = 3;
						$height = 3;
						$col = 12 / $width;
						$row = 0;
						
						foreach($get_posts as $post){
							if($i > 0 && $i % $col == 0){
								$row++;
							}
							
							$x = ($i % $col) * $width;
							$y = $row * $height;
							
							$layout = array(
								'x' => $x,
								'y' => $y,
								'width' => $width,
								'height' => $height,
								'post_id' => $post->ID
							);
							
							array_push($query_layout, $layout);
							$i ++;
						}
						
						$list_layout = $query_layout;
					}
				}
				
				$paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
				$per_page = isset($_POST['per_page']) ? intval($_POST['per_page']) : $per_page;
				$get_posts = get_posts(array(
					'posts_per_page' => $per_page,
					'paged' => $paged,
					'category__in' => $category,
					'post__not_in' => $post__not_in,
					'tax_query' => array(
						array(
							'taxonomy' => 'post_format',
							'field' => 'slug',
							'terms' => array('post-format-gallery', 'post-format-link'),
						)
					)
				));*/
			break;
		}
	
		$layout_builder_count = 0;
		if(isset($layout_builder['imagealign'])){
			$layout_builder_count = count($layout_builder['imagealign']);
		}
		
		if($get_posts){
			global $post;
			
			$current_count = intval(count($post__not_in));
			
			foreach($get_posts as $i => $post){ setup_postdata($post);
				switch($page_template){
					case 'custom-list':
						$i = $current_count ++;
						$num = $i % $layout_builder_count;
						arnold_page_load_custom_list_item($module_post, $post, $category, $num);
					break;
					
					case 'blog-masonry':
						arnold_page_load_blog_masonry_item($module_post, $post, $category);
					break;
					
					case 'masonry-grid':
						arnold_page_load_masonry_grid_item($module_post, $post, $category, $list_layout);
                    break;
					
					default:
						arnold_page_load_masonry_list_item($module_post, $post, $category);
					break;
				}
			}
			wp_reset_postdata();
		}
	}
	
	exit;
	
	/*if($post_id){
		$cat_id = intval($_POST['cat_id']);
		$paged = 1;
		arnold_page_load_masonry_list($post_id, $paged, $cat_id, true);
	}*/
}
add_action('wp_ajax_arnold_interface_page_ajax_filter', 'arnold_interface_page_ajax_filter');
add_action('wp_ajax_nopriv_arnold_interface_page_ajax_filter', 'arnold_interface_page_ajax_filter');

?>