<?php global $woo_options; ?>
<div id="featured">
	<h3><?php _e('Featured','woothemes'); ?></h3>

<?php if ( ($woo_options['woo_featured_tags'] != '') && (isset($woo_options['woo_featured_tags'])) ) : ?>

    <?php
    	unset($tag_array); 
		$feat_tags_array = explode(',',$woo_options['woo_featured_tags']); // Tags to be shown
        foreach ($feat_tags_array as $tags){ 
			$tag = get_term_by( 'name', trim($tags), 'post_tag', 'ARRAY_A' );
			if ( $tag['term_id'] > 0 ) {
				$tag_array[] = $tag['term_id'];
			}
		}
		$saved = $wp_query; 
		$count = 0; 
		if (!empty($tag_array)) : //print_r($tag_array);
    ?>
	<?php query_posts(array('tag__in' => $tag_array, 'showposts' => $woo_options['woo_featured_entries'])); ?>
	<?php if (have_posts()) : while (have_posts()) : the_post();?>

	<div class="post fl">
		
		<div class="block<?php if ( $woo_options['woo_ad_panel'] <> 'true' ) echo ' full'; ?>">
		
	        <?php woo_image('key=image&width=119&height=90&class=fl'); ?>        
			<h2><a title="<?php the_title(); ?>" href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
            
            <div class="entry">
				<p><?php echo woo_excerpt( get_the_excerpt(), '160'); ?></p>
			</div>
			
			<span class="comment"><?php comments_popup_link(__('0 Comments','woothemes'), __('1 Comment','woothemes'), __('% Comments','woothemes'),'',''); ?></span>
			<span class="more"><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php _e('Read more','woothemes'); ?></a> &raquo;</span>
		
			<div class="clear"></div>
		</div><!--/block-->
	
	</div><!--/post-->

	<?php endwhile; endif; $wp_query = $saved; ?> 
	<?php else: ?>
	<?php echo do_shortcode('[box type="info"]No posts with your specified tag(s) were found[/box]'); ?>
	<?php endif; ?>
    
<?php else : ?>
	<?php echo do_shortcode('[box type="info"]Please setup tag(s) in your options panel that are used in posts.[/box]'); ?>
 <?php endif ?> 

	<?php if ( $woo_options['woo_ad_panel'] == 'true' ) { ?>
    <div id="adpanel fr">
		<?php 
			if ($woo_options['woo_ad_panel_adsense'] <> "") { 
				echo stripslashes($woo_options['woo_ad_panel_adsense']); 
			} else {
		?>
			<a href="<?php echo $woo_options['woo_ad_panel_url']; ?>"><img src="<?php echo $woo_options['woo_ad_panel_image']; ?>" width="120" height="240" alt="advert" /></a>
			
		<?php } ?>		   	
	</div><!-- /#adpanel -->
    <?php } ?>

<div class="clear"></div>
</div><!--/featured-->