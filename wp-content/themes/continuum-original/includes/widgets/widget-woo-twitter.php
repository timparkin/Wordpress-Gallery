<?php
/*---------------------------------------------------------------------------------*/
/* Twitter widget */
/*---------------------------------------------------------------------------------*/
class Woo_Twitter extends WP_Widget {

   function Woo_Twitter() {
	   $widget_ops = array('description' => 'Add your Twitter feed to your sidebar with this widget.' );
       parent::WP_Widget(false, __('Woo - Twitter Stream', 'woothemes'),$widget_ops);      
   }
   
   function widget($args, $instance) {  
    extract( $args );
    $limit = $instance['limit']; if (!$limit) $limit = 5;
	$username = $instance['username'];
	$unique_id = $args['widget_id'];
	?>
		<?php echo $before_widget; ?>
        <span class="tlogo"><img src="<?php bloginfo('template_directory'); ?>/images/twitter.png" /></span>
        <div class="back"><ul id="twitter_update_list_<?php echo $unique_id; ?>"><li></li></ul>
        <p><?php _e('Follow','woothemes'); ?> <a href="http://twitter.com/<?php echo $username; ?>"><strong>@<?php echo $username; ?></strong></a> <?php _e('on Twitter','woothemes'); ?></p></div><div class="clear"></div>
        <?php echo woo_twitter_script($unique_id,$username,$limit); //Javascript output function ?>	 
        <?php echo $after_widget; ?>
        
   		
	<?php
   }

   function update($new_instance, $old_instance) {                
       return $new_instance;
   }

   function form($instance) {        
   
       $limit = esc_attr($instance['limit']);
	   $username = esc_attr($instance['username']);
       ?>
       <p>
	   	   <label for="<?php echo $this->get_field_id('username'); ?>"><?php _e('Username:','woothemes'); ?></label>
	       <input type="text" name="<?php echo $this->get_field_name('username'); ?>"  value="<?php echo $username; ?>" class="widefat" id="<?php echo $this->get_field_id('username'); ?>" />
       </p>
       <p>
	   	   <label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e('Limit:','woothemes'); ?></label>
	       <input type="text" name="<?php echo $this->get_field_name('limit'); ?>"  value="<?php echo $limit; ?>" class="" size="3" id="<?php echo $this->get_field_id('limit'); ?>" />

       </p>
      <?php
   }
   
} 
register_widget('Woo_Twitter');
?>