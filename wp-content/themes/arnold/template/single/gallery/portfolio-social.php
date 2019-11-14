<?php
$show_share = true;
$enable_share_buttons = arnold_get_option('theme_option_show_share_button_project');
$share_buttons = arnold_get_option('theme_option_share_buttons');

if(!$enable_share_buttons){
	$show_share = false;
}

if($show_share){ ?>
	<div class="social-bar">
		<ul class="post_social post-meta-social">
			<?php
			if(is_array($share_buttons)){
	
				$post_link = get_permalink();
				$post_link_pure = preg_replace('#^https?://#', '', rtrim($post_link,'/'));
				
				//facebook
				if(in_array('facebook', $share_buttons)){ ?>
			
					<li class="post-meta-social-li">
						<a class="share postshareicon-facebook-wrap" href="http://www.facebook.com/sharer.php?u=<?php echo esc_url($post_link); ?>" onclick="window.open('http://www.facebook.com/sharer.php?u=<?php echo esc_url($post_link); ?>','Facebook','width=600,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+''); return false;">
						<span class="fa fa-facebook postshareicon-facebook"></span>
						</a>
					</li>
				
				<?php }
				
				//twitter
				if(in_array('twitter', $share_buttons)){ ?>
				
					<li class="post-meta-social-li">
						<a class="share postshareicon-twitter-wrap" href="http://twitter.com/share?url=<?php echo esc_url($post_link); ?>&amp;text=<?php echo esc_attr(get_the_title()); ?>" onclick="window.open('http://twitter.com/share?url=<?php echo esc_url($post_link); ?>&amp;text=<?php echo esc_attr(get_the_title()); ?>','Twitter share','width=600,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+''); return false;" >
						<span class="fa fa-twitter postshareicon-twitter"></span>
						</a>
					</li>
				
				<?php }
				
				//google-plus
				if(in_array('google-plus', $share_buttons)){ ?>
		
					<li class="post-meta-social-li">
						<a class="share postshareicon-googleplus-wrap" href="https://plus.google.com/share?url=<?php echo esc_url($post_link); ?>" onclick="window.open('https://plus.google.com/share?url=<?php echo esc_url($post_link); ?>','', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
						<span class="fa fa-google-plus postshareicon-googleplus"></span>
						</a>
					</li>
				
				<?php }
				
				//pinterest
				if(in_array('pinterest', $share_buttons)){
					$image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); 
					$thumbnail = $image ? $image[0] : false; ?>
					
					<li class="post-meta-social-li">
						<a class="share postshareicon-pinterest-wrap" href="javascript:;" onclick="javascript:window.open('http://pinterest.com/pin/create/bookmarklet/?url=<?php echo esc_url($post_link); ?>&amp;is_video=false&amp;media=<?php echo esc_url($thumbnail); ?>','', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
						<span class="fa fa-pinterest  postshareicon-pinterest"></span>
						</a>
					</li>
			
				<?php }

				//Digg
				if(in_array('digg', $share_buttons)){ ?>
		
					<li class="post-meta-social-li">
						<a class="share postshareicon-digg-wrap" href="http://www.digg.com/submit?url=<?php echo esc_url($post_link); ?>" onclick="window.open('http://www.digg.com/submit?url=<?php echo esc_url($post_link); ?>','Digg','width=715,height=330,left='+(screen.availWidth/2-357)+',top='+(screen.availHeight/2-165)+''); return false;">
						<span class="fa fa-digg postshareicon-digg"></span>
						</a>
					</li>
				
				<?php }

				//Readdit
				if(in_array('reddit', $share_buttons)){ ?>
		
					<li class="post-meta-social-li">
						<a class="share postshareicon-reddit-wrap" href="http://reddit.com/submit?url=<?php echo esc_url($post_link); ?>&amp;title=<?php echo esc_attr(get_the_title()); ?>" onclick="window.open('http://reddit.com/submit?url=<?php echo esc_url($post_link); ?>&amp;title=<?php echo esc_attr(get_the_title()); ?>','Reddit','width=617,height=514,left='+(screen.availWidth/2-308)+',top='+(screen.availHeight/2-257)+''); return false;">
						<span class="fa fa-reddit postshareicon-reddit"></span>
						</a>
					</li>
				
				<?php }

				//linkedin
				if(in_array('linkedin', $share_buttons)){ ?>
		
					<li class="post-meta-social-li">
						<a class="share postshareicon-linkedin-wrap" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo esc_url($post_link); ?>" onclick="window.open('http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo esc_url($post_link); ?>','Linkedin','width=863,height=500,left='+(screen.availWidth/2-431)+',top='+(screen.availHeight/2-250)+''); return false;">
						<span class="fa fa-linkedin postshareicon-linkedin"></span>
						</a>
					</li>
				
				<?php }

				//stumbleupon
				if(in_array('stumbleupon', $share_buttons)){ ?>
		
					<li class="post-meta-social-li">
						<a class="share postshareicon-stumbleupon-wrap" href="http://www.stumbleupon.com/submit?url=<?php echo esc_url($post_link); ?>&amp;title=<?php echo esc_attr(get_the_title()); ?>" onclick="window.open('http://www.stumbleupon.com/submit?url=<?php echo esc_url($post_link); ?>&amp;title=<?php echo esc_attr(get_the_title()); ?>','Stumbleupon','width=600,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+''); return false;">
						<span class="fa fa-stumbleupon postshareicon-stumbleupon"></span>
						</a>
					</li>
				
				<?php }

				//tumblr
				if(in_array('tumblr', $share_buttons)){ ?>
		
					<li class="post-meta-social-li">
						<a class="share postshareicon-tumblr-wrap" href="http://www.tumblr.com/share/link?url=<?php echo esc_attr($post_link_pure); ?>&amp;name=<?php echo esc_attr(get_the_title()); ?>" onclick="window.open('http://www.tumblr.com/share/link?url=<?php  echo esc_attr($post_link_pure); ?>&amp;name=<?php echo esc_attr(get_the_title()); ?>','Tumblr','width=600,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+''); return false;">
						<span class="fa fa-tumblr postshareicon-tumblr"></span>
						</a>
					</li>
				
				<?php }

				//mail
				if(in_array('mail', $share_buttons)){ ?>
		
					<li class="post-meta-social-li">
						<a class="share postshareicon-mail-wrap" href="mailto:?Subject=<?php echo esc_attr(get_the_title()); ?>&amp;Body=<?php echo esc_url($post_link); ?>" >
						<span class="fa fa-envelope-o postshareicon-mail"></span>
						</a>
					</li>
					
				<?php
				}
			} ?>
		</ul> 
	</div>
<?php } ?>