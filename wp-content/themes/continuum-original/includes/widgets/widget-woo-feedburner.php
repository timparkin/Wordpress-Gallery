<?php
/*---------------------------------------------------------------------------------*/
/* Feedburner Widget */
/*---------------------------------------------------------------------------------*/

class woo_FeedburnerWidget extends WP_Widget {
	function woo_FeedburnerWidget() {
		$widget_ops = array('classname' => 'widget_feedburner', 'description' => 'Add a Feedburner subscription form' );
		$this->WP_Widget('feedburner', 'Woo - Feedburner', $widget_ops);
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		
		echo $before_widget;
		$title = empty($instance['title']) ? 'Subscribe Now' : apply_filters('widget_title', $instance['title']);
		$google = $instance['google'];
		$id = empty($instance['id']) ? '' : apply_filters('widget_id', $instance['id']);
		
		echo $before_title . $title . $after_title;

		if ($google) { $url = 'http://feedburner.google.com/fb/a/mailverify'; }
		else { $url = 'http://www.feedburner.com/fb/a/emailverify'; }
		
		if ($google) { $action = 'http://feedburner.google.com/fb/a/mailverify?uri=' . $id; } 
		else { $action = 'http://www.feedburner.com/fb/a/emailverifySubmit?feedId='. $id; }
		
		?>
		<div><form action="<?php echo $url; ?>" method="post" target="popupwindow" onsubmit="window.open('<?php echo $action; ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
		<input class="field" type="text" name="email" value="<?php _e('Enter your e-mail address','woothemes'); ?>" onfocus="if (this.value == '<?php _e('Enter your e-mail address','woothemes'); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('Enter your e-mail address','woothemes'); ?>';}" />
		<input type="hidden" value="<?php echo $id; ?>" name="uri"/>
		<input type="hidden" value="<?php bloginfo('name'); ?>" name="title"/>
		<input type="hidden" name="loc" value="en_US"/>			
		<input class="button" type="submit" name="submit" value="<?php _e('Submit','woothemes'); ?> &raquo;" />
		</form></div>
		<?php
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['google'] = $new_instance['google'];
		$instance['id'] = strip_tags($new_instance['id']);
		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'google' => '', 'id' => '' ) );
		$title = strip_tags($instance['title']);
		$google = $instance['google'];
		$id = strip_tags($instance['id']);
		?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('id'); ?>">Feedburner ID: <input class="widefat" id="<?php echo $this->get_field_id('id'); ?>" name="<?php echo $this->get_field_name('id'); ?>" type="text" value="<?php echo attribute_escape($id); ?>" /></label></p>
			<?php
			if ( $google ) {?>
			<p>
				<label for="<?php echo $this->get_field_id('google'); ?>">Use Feedburner Google Account?:
				<input id="<?php echo $this->get_field_id('google'); ?>" name="<?php echo $this->get_field_name('google'); ?>" type="checkbox" checked /></label></p>
			<?php } else { ?>

			<p>
				<label for="<?php echo $this->get_field_id('google'); ?>">Use Feedburner Google Account?:
				<input id="<?php echo $this->get_field_id('google'); ?>" name="<?php echo $this->get_field_name('google'); ?>" type="checkbox" /></label></p>
			
			<?php }		
	

	}
}
register_widget('woo_FeedburnerWidget');
?>