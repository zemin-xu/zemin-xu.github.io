      <?php //** Do Hook Footer
	  /**
	   * @hooked  arnold_interface_footer - 10
	   * @hooked  arnold_pb_module_portfolio_ajaxwrap - 30
	   */
	  do_action('arnold_interface_footer'); ?>

      <?php //** Do Hook Content after
      /**
       * @hooked  arnold_interface_content_after - 10
       */
      do_action('arnold_interface_content_after'); ?>
	  
	  <?php //** Do Hook Wrap after
	  /**
	   * @hooked  arnold_interface_wrap_outer_after - 10 
	   * @hooked  arnold_interface_photoswipe - 20
	   */
	  do_action('arnold_interface_wrap_after'); ?>

	  <?php wp_footer(); ?>

  </body>
</html>