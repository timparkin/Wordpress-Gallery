<?php global $woo_options; ?>

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


<div class="blogitemsummary clearfix">
    <div class="blogitemlabel">
<div class="day"><?php the_time( 'l' ); ?></div>
      <div class="date"><?php the_time( 'j F Y' ); ?></div>
      <div class="numComments"><?php comments_popup_link(__('0 Comments','woothemes'), __('1 Comment','woothemes'), __('% Comments','woothemes'),'',''); ?></div>
    </div>

    <div class="content">
      <h3 class="sifr"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
      <div class="body"><?php echo woo_excerpt( get_the_excerpt(), '300'); ?>&nbsp;<a href="<?php the_permalink() ?>" rel="bookmark">more</a></div>
    </div>
  </div>


	<?php endwhile; endif; $wp_query = $saved; ?> 
	<?php else: ?>
	<?php echo do_shortcode('[box type="info"]No posts with your specified tag(s) were found[/box]'); ?>
	<?php endif; ?>
    
<?php else : ?>
	<?php echo do_shortcode('[box type="info"]Please setup tag(s) in your options panel that are used in posts.[/box]'); ?>
 <?php endif ?> 


