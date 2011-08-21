<?php
/*---------------------------------------------------------------------------------*/
/* Authors Widget */
/*---------------------------------------------------------------------------------*/
class WP_Widget_Authors extends WP_Widget {

	function WP_Widget_Authors() {
		$widget_ops = array('classname' => 'widget_authors', 'description' => __('Authors Widget'));
		//$control_ops = array('width' => 400, 'height' => 350);
		$this->WP_Widget('woo_authors', __('Woo - Authors'), $widget_ops /*,$control_ops*/);
	}

	function widget( $args, $instance ) {
		global $wpdb;
		extract($args);
		$title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
		$level = apply_filters( 'widget_level', empty($instance['level']) ? '' : $instance['level'], $instance, $this->id_base);


		echo $before_widget;
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } ?>
		
			<div class="authorwidget">
			<?php
			if($level == 'a'){ $select = '> 0'; }
			else if($level == 'b'){ $select = '= 10'; }
			else if($level == 'c'){ $select = '= 7'; }
			else if($level == 'd'){ $select = '= 2'; }
			else if($level == 'e'){ $select = '= 1'; }
			
			$query = "SELECT DISTINCT $wpdb->users.ID, $wpdb->users.user_login, $wpdb->users.display_name, $wpdb->users.user_email
FROM $wpdb->users LEFT JOIN $wpdb->usermeta ON $wpdb->users.id = $wpdb->usermeta.user_id WHERE meta_key = 'wp_user_level' AND meta_value $select";
									
			if ( !$authors = wp_cache_get( 'authors_query', 'authors_widget' ) ) {
    			$authors = $wpdb->get_results($query);
       			wp_cache_add( 'authors_query', $authors, 'authors_widget' );
    		}
			if(!empty($authors)){ 
				foreach($authors as $author){ ?>
					<div class="author-item">
					<span class="avatar"><?php echo get_avatar($author->user_email, 44); ?></span>
					<h4><?php echo $author->display_name; ?></h4>
					<?php if(!empty($author->user_email)){ ?>
						<p><?php _e('Email','woothemes'); ?>: <?php echo $author->user_email; ?></p>
					<?php } ?>
					</div>
				<?php
				}	
			}
			?>
			</div>
		<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['level'] = strip_tags($new_instance['level']);

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		$title = strip_tags($instance['title']);
		$level = strip_tags($instance['level']);

?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('level'); ?>"><?php _e('User level to show:'); ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id('level'); ?>" name="<?php echo $this->get_field_name('level'); ?>"> 
			<?php
			$array = array(
				'a'=> 'Admins, Editors, Authors, Contributors',
				'b'=>'Just Admins',
				'c'=>'Just Editors',
				'd'=>'Just Authors',
				'e'=>'Just Contributors'
			);
			foreach($array as $key => $value){ 
				if($level == $key) { $selected = 'selected="selected"'; } else { $selected = '';}
			?>
				<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $value; ?></option>
			<?php
			}
			?>
		</select>		
		</p>

<?php
	}
}


register_widget('WP_Widget_Authors');
?>