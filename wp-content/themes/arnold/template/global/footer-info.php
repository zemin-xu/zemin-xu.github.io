<div class="footer-info">
    <div class="container">
        <?php
        $elements = arnold_get_option('theme_option_footer_elements');
        $elements_align = arnold_get_option('theme_option_footer_elements_align');
		
		if($elements && is_array($elements)){
			$types = $elements['type'];
			$menus = $elements['menu'];
			$texts = $elements['text'];
			
			$i = count($types);
			
			$horizon_class = 'col-lg-3 col-md-3 col-sm-3';
			
			if($elements_align == 'horizon'){
				if(count($types) > 4){
					$i = 4;
				}
				
				switch(count($types)){
					case 1: $horizon_class = 'col-lg-12 col-md-12 col-sm-12'; break;
					case 2: $horizon_class = 'col-lg-6 col-md-6 col-sm-6'; break;
					case 3: $horizon_class = 'col-lg-4 col-md-4 col-sm-4'; break;
				}
			}
			
			for($ii=0; $ii<$i; $ii++){
				$type = $types[$ii];
				$memu = $menus[$ii];
				$text = $texts[$ii];
				
				if($elements_align != 'vertical'){
					echo '<div class="footer-cols-item ' .$horizon_class. ' col-xs-12">';
				}
				
				arnold_interface_footer_info_element($type, $memu, $text);
				
				if($elements_align != 'vertical'){
					echo '</div>';
				}
			}
						
		} ?>
    </div>
</div>