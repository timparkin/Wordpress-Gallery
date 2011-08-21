<div id="sidebar" class="col-right">

	<?php if (is_single()) { ?>
	
	<div class="postmeta">
		<h3><?php _e('About this article', 'woothemes') ?></h3>		
		<ul>
			<li class="post-date"><?php _e('Posted on', 'woothemes') ?> <?php the_time( get_option( 'date_format' ) ); ?></span></li>
			<li class="post-category"><?php _e('Archived in', 'woothemes') ?> <?php the_category(', ') ?></li>
			<li class="post-comment"><?php _e('There are', 'woothemes') ?> <?php comments_popup_link(__('0 responses','woothemes'), __('1 response','woothemes'), __('% responses','woothemes')); ?>.</li>
		    <?php edit_post_link( __('Edit this post', 'woothemes'), '<li class="edit">', '</li>' ); ?>
		 </ul>
	</div>
	
	<?php } ?>

	<?php if (woo_active_sidebar('primary')) : ?>
    <div class="primary">
		<?php woo_sidebar('primary'); ?>		           
	</div>        
	<?php endif; ?>

</div><!-- /#sidebar -->