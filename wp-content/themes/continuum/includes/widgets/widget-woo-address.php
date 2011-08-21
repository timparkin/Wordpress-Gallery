<?php
/*---------------------------------------------------------------------------------*/
/* Address Widget */
/*---------------------------------------------------------------------------------*/
class WP_Widget_Address extends WP_Widget {

	function WP_Widget_Address() {
		$widget_ops = array('classname' => 'widget_address', 'description' => __('Text or HTML with Google Maps functionality'));
		$control_ops = array('width' => 400, 'height' => 350);
		$this->WP_Widget('woo_address', __('Woo - Address'), $widget_ops, $control_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
		$subtitle = apply_filters( 'widget_subtitle', empty($instance['subtitle']) ? '' : $instance['subtitle'], $instance, $this->id_base);
		$text = apply_filters( 'widget_text', $instance['text'], $instance );
		$coords = apply_filters( 'widget_coords', $instance['coords'], $instance );
		$zoom = apply_filters( 'widget_zoom', $instance['zoom'], $instance );

		echo $before_widget;
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } ?>
		
			<div class="textwidget">
			<?php if ( !empty( $subtitle ) ) { echo '<h4>' . $subtitle . '</h4>'; } ?>
			<?php echo $instance['filter'] ? wpautop($text) : $text; ?>
			<?php if(!empty($coords)){ ?>
			<?php if(empty($zoom)) $zoom = 14; ?>
			<img class="maps-image" src="http://maps.google.com/maps/api/staticmap?center=<?php echo $coords; ?>&zoom=<?php echo $zoom; ?>&size=248x150&maptype=roadmap
&markers=color:red|label:A|<?php echo $coords; ?>&sensor=false" />
			<?php } ?>
			</div>
		<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['subtitle'] = strip_tags($new_instance['subtitle']);
		if ( current_user_can('unfiltered_html') )
			$instance['text'] =  $new_instance['text'];
		else
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) ); // wp_filter_post_kses() expects slashed
		$instance['filter'] = isset($new_instance['filter']);
		$instance['coords'] = strip_tags($new_instance['coords']);
		$instance['zoom'] = strip_tags($new_instance['zoom']);
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '','subtitle' => '', 'text' => '' ,'coords' => '' ,'zoom' => '' ) );
		$title = strip_tags($instance['title']);
		$subtitle = strip_tags($instance['subtitle']);
		$text = format_to_edit($instance['text']);
		$coords = format_to_edit($instance['coords']);
		$zoom = format_to_edit($instance['zoom']);
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('Sub Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('subtitle'); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>" type="text" value="<?php echo esc_attr($subtitle); ?>" /></p>

		<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>
		<p><input id="<?php echo $this->get_field_id('filter'); ?>" name="<?php echo $this->get_field_name('filter'); ?>" type="checkbox" <?php checked(isset($instance['filter']) ? $instance['filter'] : 0); ?> />&nbsp;<label for="<?php echo $this->get_field_id('filter'); ?>"><?php _e('Automatically add paragraphs'); ?></label></p>

		<p><label for="<?php echo $this->get_field_id('coords'); ?>"><?php _e('Location Coordinates:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('coords'); ?>" name="<?php echo $this->get_field_name('coords'); ?>" type="text" value="<?php echo esc_attr($coords); ?>" />
		<small style="color:#999">Eg. 40.704196,-73.994563 -OR- Brooklyn Bridge, New York, United States</small>
		</p>
		
		<p><label for="<?php echo $this->get_field_id('zoom'); ?>"><?php _e('Zoom Level:'); ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id('zoom'); ?>" name="<?php echo $this->get_field_name('zoom'); ?>"> 
			<?php
			for($i = 0; $i < 20; $i++){ 
				if($i == 0){ $meta = ' (Furthest)';}
				else if($i == 19){ $meta = ' (Closest)';}
				else { $meta = '';}
				if($zoom == $i) { $selected = 'selected="selected"'; } else { $selected = '';}
			?>
				<option value="<?php echo $i; ?>" <?php echo $selected; ?>><?php echo $i; echo $meta; ?></option>
			<?php
			}
			?>
		</select>		
		</p>



<?php
	}
}


register_widget('WP_Widget_Address');
?>