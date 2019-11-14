<?php  $enter_key =  esc_html__('Search','arnold'); ?>
<form id="searchform" name="search" method="get" action="<?php echo home_url('/'); ?>/">	
<input type="text" onBlur="if (this.value == '') {this.value = '<?php echo esc_attr($enter_key); ?>';}" onFocus="if (this.value == '<?php echo esc_attr($enter_key); ?>') {this.value = '';}" name="s" value="<?php echo esc_attr($enter_key); ?>">
</form>
