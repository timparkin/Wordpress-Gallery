<div id="popular">
	<h3><?php _e('Most Popular','woothemes'); ?></h3>
	<div class="plate">
	<?php
		global $post;
		$count = 0; 
		$popular = get_posts('orderby=comment_count&showposts='.$woo_options['woo_popular_entries']);
		foreach($popular as $post) :
			setup_postdata($post);
			$count++;
	?>
		<div class="post fl">
			<div class="block">
		        <?php woo_get_image('image', '64', '48','fr'); ?>        
						
				<h2><a title="<?php the_title(); ?>" href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				<span class="meta"><?php _e('By', 'woothemes') ?> <?php the_author_posts_link(); ?> <?php _e('on', 'woothemes') ?> <?php the_time( get_option( 'date_format' ) ); ?></span><br/>
				<span class="comment"><?php comments_popup_link(__('0 Comments','woothemes'), __('1 Comment','woothemes'), __('% Comments','woothemes'),'',''); ?></span>
			</div><!--/block-->
		
		</div><!--/post-->
		<?php if ( $count == 2 ) { $count = 0; echo '<div class="clear"></div>'; } ?>
	
	<?php endforeach; ?>

	<div class="clear"></div>
	</div>
</div><!--/popular-->   
