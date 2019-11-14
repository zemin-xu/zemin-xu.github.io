<?php //** if enable sidebar
if(arnold_enable_sidebar()){ ?>
	<aside id="sidebar-widget" class="col-md-3 col-sm-3" >
	
		<ul class="sidebar_widget">

			<?php
			$default_widgets = 'sidebar_1';
			if(is_singular('post') || is_page()){
				$sidebar_widgets = arnold_get_post_meta(get_the_ID(), 'theme_meta_sidebar_widgets');
				
				if(is_singular('post')){
					$post_sidebar = arnold_get_post_meta(get_the_ID(), 'theme_meta_sidebar');
				}
				
				if($sidebar_widgets) {
					$default_widgets = $sidebar_widgets;
				}
			}
			
			dynamic_sidebar($default_widgets); ?>

		</ul>	

	</aside>
	
<?php } ?>