<?php
//contact form template
function ux_pb_module_contactform($itemid){
	global $ux_pagebuilder; 
	$module_post = $ux_pagebuilder->item_postid($itemid);
	
	if($module_post){
		//contact form confing
		$type              = get_post_meta($module_post, 'module_contactform_type', true);
		$message           = get_post_meta($module_post, 'module_contactform_message', true);
		$verifynumber      = get_post_meta($module_post, 'module_contactform_verifynumber', true);
		$show_captcha      = get_post_meta($module_post, 'module_contactform_captcha', true);
		$button_text       = get_post_meta($module_post, 'module_contactform_button_text', true);
		$comment_placehold = get_post_meta($module_post, 'module_contactform_comment_placehold', true);
		$field_text        = get_post_meta($module_post, 'module_contactform_field_text', true);
		$recipient_email   = get_post_meta($module_post, 'module_contactform_recipient_email', true);

		$button_text       = $button_text ? $button_text : __('SEND','ux');
		$comment_placehold = $comment_placehold ? $comment_placehold : __('YOUR MESSAGE','ux');
		$message           = $message ? $message : __('Your message has been successfully sent!','ux');
		
		switch($type){
			case 'contact_form': ?>
                <div class="contactform ux-mod-nobg">
                    <form action="<?php $_SERVER['REQUEST_URI']; ?>" id="contact-form" class="contact_form" method="POST">
                        <p class="span6"><input type="text" id="idi_name" name="idi_name" class="requiredField" value="<?php esc_attr_e('Name','ux'); ?>" onBlur="if (this.value =='' ) {this.value = '<?php esc_attr_e('Name','ux'); ?>';}" onFocus="if (this.value == '<?php esc_attr_e('Name','ux'); ?>' || this.value == '<?php esc_attr_e('Required','ux'); ?>' ) { this.value = ''; }" /></p>
                        <p class="span6"><input type="text" id="idi_mail" name="idi_mail" class="requiredField email" value="<?php esc_attr_e('Email','ux'); ?>" onBlur="if (this.value =='' ) {this.value = '<?php esc_attr_e('Email','ux'); ?>';}" onFocus="if (this.value == '<?php esc_attr_e('Email','ux'); ?>' || this.value  == '<?php esc_attr_e('Required','ux'); ?>' || this.value == '<?php esc_attr_e('Invalid email','ux'); ?>' ) {this.value = '';}" /></p>
                        <p><textarea rows="4" name="idi_text" id="idi_text" cols="4" class="requiredField inputError"  onfocus="if(this.value==this.defaultValue|| this.value  == '<?php esc_attr_e('Required','ux'); ?>'){this.value='';}" onblur="if(this.value==''){this.value=this.defaultValue;}" ><?php echo esc_textarea($comment_placehold); ?></textarea></p>
                        <input type="hidden" class="info-tip" value="send" name="contact_form" data-message="<?php echo esc_attr($message); ?>" data-sending="<?php esc_attr_e('Sending','ux')?>" data-error="<?php esc_attr_e('Please Enter Correct Verification Number','ux')?>" />
                        <div class="btnarea">
							<?php /*if($show_captcha == 'on'){
								$captcha = new UXCaptcha();
								$prefix = mt_rand();
								$captcha_word = $captcha->generate_random_word();
								$captcha_img = $captcha->generate_image($prefix, $captcha_word); ?>
                                 
								<div class="verify-wrap">
                                    <input type="hidden" value="<?php echo esc_attr($captcha_word); ?>" name="ux_captcha_word" />
                                    <input type="text" id="enterVerify" name="enterVerify" class="requiredField captcha" value="<?php esc_attr_e('CAPTCHA','ux'); ?>" onBlur="if (this.value =='' ) {this.value = '<?php esc_attr_e('CAPTCHA','ux'); ?>';}" onFocus="if (this.value == '<?php esc_attr_e('CAPTCHA','ux'); ?>' ) { this.value = ''; }"/>
                                    <span class="verifyNum" id="verifyNum"><img src="<?php echo esc_url($captcha->ux_captcha_tmp_url()) . '/' . $captcha_img; ?>" /></span>
                                </div>
							<?php }*/ ?>
                            <input type="submit" id="idi_send" name="idi_send" value="<?php echo esc_attr($button_text); ?>" />
                        </div>
                
                    </form>
                </div>
				<?php if(isset($_POST['contact_form']) && $_POST['contact_form'] == 'send'){
                    $name = isset($_POST['idi_name']) ? esc_html(trim(htmlspecialchars($_POST['idi_name']), ENT_QUOTES)) : '';
                    $email = isset($_POST['idi_mail']) ? is_email(trim(htmlspecialchars($_POST['idi_mail']), ENT_QUOTES)) : '';
                    $content = isset($_POST['idi_text']) ? esc_html(trim(htmlspecialchars($_POST['idi_text']), ENT_QUOTES)) : '';
                    $post_content = "This mail was sent by  $name .  Content:  $content";
                    $title = 'Mail from '. is_email($email);
                    $headers = 'Content-type: text/html; charset=utf-8' . "\r\n";
                    wp_mail(is_email($recipient_email), $title, $post_content, $headers);
                }
			break;
			
			case 'single_field': ?>
                <form action="#" id="contact-form" class="contact_form single-feild" method="POST">
                    <input type="text" id="idi_mail" name="idi_name" class="requiredField email" value="<?php echo esc_attr($field_text); ?>" onBlur="if (this.value =='' ) {this.value = '<?php echo esc_attr($field_text); ?>';}" onFocus="if (this.value == '<?php echo esc_attr($field_text); ?>' || this.value  == 'Required' || this.value == 'Invalid email' ) {this.value = '';}" />
                    <input type="hidden" value="send" name="single_form" data-message="<?php echo esc_attr($message); ?>" data-sending="<?php esc_attr_e('Sending','ux')?>" />
                    <?php /*if($show_captcha == 'on'){
						$captcha = new UXCaptcha();
						$prefix = mt_rand();
						$captcha_word = $captcha->generate_random_word();
						$captcha_img = $captcha->generate_image($prefix, $captcha_word); ?>
						 
						<div class="verify-wrap">
							<input type="hidden" value="<?php echo esc_attr($captcha_word); ?>" name="ux_captcha_word" />
							<input type="text" id="enterVerify" name="enterVerify" class="requiredField captcha" value="<?php esc_attr_e('Captcha','ux'); ?>" onBlur="if (this.value =='' ) {this.value = '<?php esc_attr_e('Captcha','ux'); ?>';}" onFocus="if (this.value == '<?php esc_attr_e('Captcha','ux'); ?>' ) { this.value = ''; }" />
							<span class="verifyNum" id="verifyNum"><img src="<?php echo esc_url($captcha->ux_captcha_tmp_url()) . '/' . $captcha_img; ?>" /></span>
						</div>
					<?php }*/ ?>
                    <input type="submit" id="idi_send" name="idi_send" class="idi_send" value="<?php echo esc_attr($button_text); ?>" />
                </form>
				<?php
                if(isset($_POST['single_form']) && $_POST['single_form'] == 'send'){
					$email = isset($_POST['idi_mail'] ) ? trim(htmlspecialchars($_POST['idi_mail'], ENT_QUOTES)) : '';
					$post_content = "This mail was sent by  $email ";
					$title = 'Subscription from '.$email;
					$headers = 'Content-type: text/html; charset=utf-8' . "\r\n";
					wp_mail(is_email($recipient_email), $title, $post_content, $headers);
				}
			break;
			
			case 'contactform7':
				$contactform7 = get_post_meta($module_post, 'module_contactform_contactform7', true);
							
				if($contactform7){
					$get_cf7 = $contactform7;
					$shortcode = '[contact-form-7 id="' . $get_cf7 . '" title="' . get_the_title($get_cf7) . '"]';
					echo do_shortcode($shortcode);
				}
			break;
		}
		
	}
}
add_action('ux-pb-module-template-contact-form', 'ux_pb_module_contactform');

//contact form select fields
function ux_pb_module_contactform_select($fields){
	$fields['module_contactform_type'] = array(
		array('title' => __('Contact Form','ux'), 'value' => 'contact_form'),
		array('title' => __('Single Field','ux'), 'value' => 'single_field')
	);
	
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_contactform_select');

//contact form config fields
function ux_pb_module_contactform_fields($module_fields){
	$module_fields['contact-form'] = array(
		'id' => 'contact-form',
		'animation' => true,
		'title' => __('Contact Form','ux'),
		'item' =>  array(
			array('title' => __('Form Type','ux'),
				  'type' => 'select',
				  'name' => 'module_contactform_type',
				  'default' => 'contact_form'),
						
			array('title' => __('Recipient Email','ux'),
				  'description' => __('Enter the email to receive the messages.','ux'),
				  'type' => 'text',
				  'name' => 'module_contactform_recipient_email',
				  'control' => array(
					  'name' => 'module_contactform_type',
					  'value' => 'contact_form|single_field'
				  )),
				  
			array('title' => __('Field Text','ux'),
				  'type' => 'text',
				  'name' => 'module_contactform_field_text',
				  'control' => array(
					  'name' => 'module_contactform_type',
					  'value' => 'single_field'
				  )),

			array('title' => __('Message Box placeholder','ux'),
				  'description' => '',
				  'type' => 'text',
				  'name' => 'module_contactform_comment_placehold',
				  'control' => array(
					  'name' => 'module_contactform_type',
					  'value' => 'contact_form'
				  )),


			array('title' => __('Button Text','ux'),
				  'description' => __('Enter the text you want to show on button.','ux'),
				  'type' => 'text',
				  'name' => 'module_contactform_button_text',
				  'control' => array(
					  'name' => 'module_contactform_type',
					  'value' => 'contact_form|single_field'
				  )),
				  
			array('title' => __('Sent Message','ux'),
				  'description' => __('Enter the inform information you want to show after user send out the message.','ux'),
				  'type' => 'textarea',
				  'name' => 'module_contactform_message',
				  'control' => array(
					  'name' => 'module_contactform_type',
					  'value' => 'contact_form|single_field'
				  )),
				  
			array('title' => __('Advanced Settings','ux'),
				  'description' => __('magin and animations','ux'),
				  'type' => 'switch',
				  'name' => 'module_advanced_settings',
				  'default' => 'off'),
				  
			array('title' => __('Bottom Margin','ux'),
				  'description' => __('the spacing outside the bottom of module','ux'),
				  'type' => 'select',
				  'name' => 'module_bottom_margin',
				  'default' => 'bottom-space-40',
				  'control' => array(
					  'name' => 'module_advanced_settings',
					  'value' => 'on'
				  ))
			
		)
	);
	return $module_fields;
	
}
add_filter('ux_pb_module_fields', 'ux_pb_module_contactform_fields');

//Contact Form 7 select fields
function ux_pb_module_contactform7_select($fields){
	if(is_plugin_active('contact-form-7/wp-contact-form-7.php') && isset($fields['module_contactform_type'])){
		$get_cf7 = get_posts(array(
			'posts_per_page' => -1,
			'post_type' => 'wpcf7_contact_form'
		));
		
		if(count($get_cf7)){
			$cf7 = array();
			foreach($get_cf7 as $form){
				array_push($cf7, array(
					'title' => $form->post_title, 'value' => $form->ID
				));
			}
			
			$fields['module_contactform_contactform7'] = $cf7;
		}
		
		array_push($fields['module_contactform_type'], array(
			'title' => __('Contact Form 7','ux'), 'value' => 'contactform7'
		));
	}
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_contactform7_select', 10);

//Contact Form 7 config fields
function ux_pb_module_contactform7_fields($module_fields){
	if(is_plugin_active('contact-form-7/wp-contact-form-7.php') && isset($module_fields['contact-form'])){
		array_push($module_fields['contact-form']['item'], array(
			'title' => __('Contact Form 7 Alias','ux'),
			'type' => 'select',
			'name' => 'module_contactform_contactform7',
			'control' => array(
				'name' => 'module_contactform_type',
				'value' => 'contactform7'
			)
		));
	}
	return $module_fields;
}
add_filter('ux_pb_module_fields', 'ux_pb_module_contactform7_fields', 10);
?>