<?php

/* SETUP THE COMMENTS SECTION  */
if ( 'open' == $post->comment_status ) :
?>
<div id="comments" class="container">
	<?php /* DISPLAY THE COMMENTS  */
	if ( have_comments() ) : ?>

	<div id="comments_box">
		<h3 class="comment-box-tit"><?php comments_number(esc_html__('0 Response', 'arnold'), esc_html__('1 Response', 'arnold'), esc_html__('% Responses', 'arnold') ); ?></h3>
		<?php $ping_count = $comment_count = 0;
		foreach ( $comments as $comment )
	          get_comment_type() == "comment" ? ++$comment_count : ++$ping_count;
		  if (  empty($comments_by_type['comment']) ) : ?>
				<?php $total_pages = get_comment_pages_count(); if ( $total_pages > 1 ) : ?>
					<div class="commnetsnavi">
						<div class="paginated-comments-links"><?php paginate_comments_links(); ?></div>
					</div><!-- #comments-nav-above -->
				<?php endif; ?>                   
				<ol class="commentlist commentlist-only">
					<?php wp_list_comments(array(
						'type' => 'comment',
						'callback' => 'arnold_cust_comment',
						'short_ping' => true
					)); ?>
				</ol>
				<?php $total_pages = get_comment_pages_count(); if ( $total_pages > 1 ) : ?>
					<div class="commnetsnavi">
						<div class="paginated-comments-links"><?php paginate_comments_links(); ?></div>
					</div><!-- #comments-nav-below -->
				<?php endif; ?>                   
		<?php endif; /* if ( $comment_count ) */ ?>
	</div><!-- #comments_box-->	

	<?php endif /* if ( $comments ) */ ?>

<?php
    $req = get_option('require_name_email'); // Checks if fields are required.
	$pathinfo = pathinfo($_SERVER['SCRIPT_FILENAME']);
    if ( 'comments.php' == $pathinfo['basename'] )
        die ( 'Please do not load this page directly. Thanks!' );
    if(post_password_required()):
?>
	<div class="nopassword"><?php esc_html_e("This post is password protected. Enter the password to view any comments.", 'arnold'); ?></div>
</div><!-- .comments ? -->
<?php
        return;
    endif;
?>
<?php /* COMMENT ENTRY FORM  */ ?>
	<div id="respondwrap" class="comment-respond">
		<?php 
			$commenter = wp_get_current_commenter();
			$req = get_option( 'require_name_email' );
			$aria_req = ( $req ? " aria-required='true'" : '' );
			$name_text = esc_attr__('Name','arnold');
			$email_text = esc_attr__('Email','arnold');
			$website_text = esc_attr__('Website','arnold');
			$review_text = arnold_get_option('theme_option_descriptions_your_message');
			$review_text = $review_text ? $review_text : esc_attr__('Leave your comment here','arnold');
			$review_tit  = arnold_get_option('theme_option_descriptions_comment_title');
			$review_tit  = $review_tit ? $review_tit : esc_attr__( 'Leave a Comment','arnold' );
			$review_submit = arnold_get_option('theme_option_descriptions_comment_submit');
			$review_submit = $review_submit ? $review_submit : esc_attr__( 'Send Comment','arnold' );

			if(esc_attr( $commenter['comment_author'] )){
			$fields =  array(
				'author' => '<p><input id="author" name="author" type="text" class="requiredFieldcomm" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' tabindex="1" onfocus="if(this.value==\''.esc_attr($name_text).'\'){this.value=\'\';}" onblur="if(this.value==\'\'){this.value=\''.esc_attr($name_text).'\';}"/></p>',
				'email' => '<p><input id="email" name="email" type="text" class="email requiredFieldcomm" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' tabindex="2" onfocus="if(this.value==\''.esc_attr($email_text).'\'){this.value=\'\';}" onblur="if(this.value==\'\'){this.value=\''.esc_attr($email_text).'\';}"/></p>',
				'url' => '<p><input id="url" name="url" type="text" class="url requiredFieldcomm" value="' . esc_attr(  $commenter['comment_author_url'] ) . '" size="30"' . $aria_req . ' tabindex="2" onfocus="if(this.value==\''.esc_attr($website_text).'\'){this.value=\'\';}" onblur="if(this.value==\'\'){this.value=\''.esc_attr($website_text).'\';}"/></p>'
			);
			}else{
			$fields =  array(
				'author' => '<p><input id="author" name="author" type="text" class="requiredFieldcomm" value="'.esc_attr($name_text).'" size="30"' . $aria_req . ' tabindex="1" onfocus="if(this.value==\''.esc_attr($name_text).'\'){this.value=\'\';}" onblur="if(this.value==\'\'){this.value=\''.esc_attr($name_text).'\';}"/></p>',
				'email' => '<p><input id="email" name="email" type="text" class="email requiredFieldcomm" value="'.esc_attr($email_text).'" size="30"' . $aria_req . ' tabindex="2" onfocus="if(this.value==\''.esc_attr($email_text).'\'){this.value=\'\';}" onblur="if(this.value==\'\'){this.value=\''.esc_attr($email_text).'\';}"/></p>',
				'url' => '<p><input id="url" name="url" type="text" class="url requiredFieldcomm" value="'.esc_attr($website_text).'" size="30"' . $aria_req . ' tabindex="2" onfocus="if(this.value==\''.esc_attr($website_text).'\'){this.value=\'\';}" onblur="if(this.value==\'\'){this.value=\''.esc_attr($website_text).'\';}"/></p>'
			);
			}
			$comments_args = array(
			    'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
			    'logged_in_as'		   => '<p class="logged">' . sprintf( wp_kses(__( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out &raquo;</a>','arnold' ), array( 'a' => array('href' => array(), 'title' => array())) ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
			    'title_reply'          => '<span class="comm-reply-title">'.esc_html($review_tit).'</span>',
			    'title_reply_to'       => esc_html__( 'Leave a Comment to %s','arnold' ),
			    'cancel_reply_link'    => esc_html__( 'Cancel Reply','arnold' ),
			    'label_submit'         => esc_html($review_submit),
			    'comment_field'		   => '<p><textarea id="comment" name="comment" class="requiredFieldcomm" cols="100%" tabindex="4" aria-required="true" onfocus="if(this.value==this.defaultValue){this.value=\'\';}" onblur="if(this.value==\'\'){this.value=this.defaultValue;}" >'.esc_textarea($review_text).'</textarea></p>',
			    'must_log_in'		   => '<p class="must-log-in">' .  sprintf( wp_kses(__( 'You must be <a href="%s">logged in</a> to post a comment.','arnold' ), array( 'a' => array('href' => array())) ), wp_login_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
                'comment_notes_after'  =>'',
                'comment_notes_before'  =>''
			);
        ?>
		<?php comment_form($comments_args); ?>
	</div>

	

</div><!-- #comments -->
<?php endif; ?>