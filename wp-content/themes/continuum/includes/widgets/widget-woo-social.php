<?php
/*---------------------------------------------------------------------------------*/
/* Address Widget */
/*---------------------------------------------------------------------------------*/
class WP_Widget_Social extends WP_Widget {

	function WP_Widget_Social() {
		$widget_ops = array('classname' => 'widget_social', 'description' => __('Add social links in your sidebar'));
		$this->WP_Widget('woo_social', __('Woo - Social'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);

		$facebook = apply_filters( 'widget_facebook', $instance['facebook'], $instance );
		$twitter = apply_filters( 'widget_twitter', $instance['twitter'], $instance );
		$flickr = apply_filters( 'widget_flickr', $instance['flickr'], $instance );
		$youtube = apply_filters( 'widget_facebook', $instance['youtube'], $instance );

		echo $before_widget;
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } ?>
		
			<div class="socialwidget">
			<?php if ( !empty( $facebook ) ) { echo '<a href="'.$facebook.'" class="ico-facebook">'.__('Facebook','woothemes') . '</a>'; } ?>
			<?php if ( !empty( $twitter ) ) { echo '<a href="'.$twitter.'" class="ico-twitter">'.__('Twitter','woothemes') . '</a>'; } ?>
			<?php if ( !empty( $flickr ) ) { echo '<a href="'.$flickr.'" class="ico-flickr">'.__('Flickr','woothemes') . '</a>'; } ?>
			<?php if ( !empty( $youtube ) ) { echo '<a href="'.$youtube.'" class="ico-youtube">'.__('Youtube','woothemes') . '</a>'; } ?>
			<div class="clear"></div>
			</div>
			
		<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['facebook'] = strip_tags($new_instance['facebook']);
		$instance['twitter'] = strip_tags($new_instance['twitter']);
		$instance['flickr'] = strip_tags($new_instance['flickr']);
		$instance['youtube'] = strip_tags($new_instance['youtube']);
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '','facebook' => '', 'twitter' => '' ,'flickr' => '' ,'youtube' => '' ) );
		$title = strip_tags($instance['title']);
		$facebook = format_to_edit($instance['facebook']);
		$twitter = format_to_edit($instance['twitter']);
		$flickr = format_to_edit($instance['flickr']);
		$youtube = format_to_edit($instance['youtube']);

?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e('Facebook URL:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" type="text" value="<?php echo esc_attr($facebook); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('twitter'); ?>"><?php _e('Twitter URL:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" type="text" value="<?php echo esc_attr($twitter); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('flickr'); ?>"><?php _e('Flickr URL:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('flickr'); ?>" name="<?php echo $this->get_field_name('flickr'); ?>" type="text" value="<?php echo esc_attr($flickr); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('youtube'); ?>"><?php _e('YouTube URL:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('youtube'); ?>" name="<?php echo $this->get_field_name('youtube'); ?>" type="text" value="<?php echo esc_attr($youtube); ?>" /></p>

		

<?php
	}
}


register_widget('WP_Widget_Social');
?>