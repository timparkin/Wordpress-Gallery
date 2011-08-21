<?php global $woo_options; ?>

<div id="loopedSlider">
	<div class="plate">
    <?php $woo_slider_tags = $woo_options['woo_slider_tags']; if ( ($woo_slider_tags != '') && (isset($woo_slider_tags)) ) { ?>
    <?php 
    	unset($tag_array); 
		$slide_tags_array = explode(',',$woo_options['woo_slider_tags']); // Tags to be shown
        foreach ($slide_tags_array as $tags){ 
			$tag = get_term_by( 'name', trim($tags), 'post_tag', 'ARRAY_A' );
			if ( $tag['term_id'] > 0 )
				$tag_array[] = $tag['term_id'];
		}
		if (!empty($tag_array)) :
    ?>
	
	<?php $saved = $wp_query; query_posts(array('tag__in' => $tag_array, 'showposts' => $woo_options['woo_slider_entries'])); ?>
	<?php if (have_posts()) : $count = 0; ?>

    <div class="container">
    
        <div class="slides">
        
            <?php while (have_posts()) : the_post(); $exclude[$count] = $post->ID; ?>
			<?php if (!woo_image('return=true')) continue; // Skip post if it doesn't have an image ?>    
            <?php $count++; ?>
            
            <div id="slide-<?php echo $count; ?>" class="slide">
        
            	<?php woo_image('key=image&width=598&height='.$woo_options['woo_slider_height'].'&class=slide-image'); ?>
            	
            	<div class="slide-content">
            	
       		     	<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
       		     	
       		     	<div class="entry">
           		     	<p><?php echo woo_excerpt( get_the_excerpt(), '100'); ?></p>
					</div>           		     	
       		     	       		 		
       		 	</div><!-- /.slide-content -->
       		     	
       		    <div class="fix"></div>
        
            </div>
            
		<?php endwhile; ?> 
			
		</div><!-- /.slides -->
		
		<?php if ($count > 1) : ?>
<a href="#" class="next"><img src="<?php bloginfo('template_directory'); ?>/images/btn-slider-next.png" alt="&gt;" /></a>
            <a href="#" class="previous"><img src="<?php bloginfo('template_directory'); ?>/images/btn-slider-prev.png" alt="&lt;" /></a>
        <?php endif; ?>
		
    </div><!-- /.container -->
    
	<div class="fix"></div>
    
    <?php endif; $wp_query = $saved; ?> 

	<?php else: ?>
	<?php echo do_shortcode('[box type="info"]No posts with your specified tag(s) were found[/box]'); ?>
	<?php endif; ?>
    
     <?php } else { ?>
	<?php echo do_shortcode('[box type="info"]Please setup tag(s) in your options panel that are used in posts.[/box]'); ?>
     <?php } ?>   
</div>
</div><!-- /#loopedSlider -->

<!-- Slider Setup -->
<script type="text/javascript">
<?php if ( is_home() && $woo_options['woo_slider'] == 'true' ) { ?>
jQuery(window).load(function(){
    jQuery("#loopedSlider").loopedSlider({
	<?php
	$autoStart = 0;
	$slidespeed = 600;
	$slidespeed = $woo_options["woo_slider_speed"] * 1000; 
	if ( $slidespeed > 5000) $slidespeed = 5000;
	if ( $woo_options["woo_slider_auto"] == "true" ) 
	   $autoStart = $woo_options["woo_slider_interval"] * 1000;
	else 
	   $autoStart = 0;
	?>
        autoStart: <?php echo $autoStart; ?>, 
        slidespeed: <?php echo $slidespeed; ?>, 
        autoHeight: true
    });
});
<?php } ?>
</script>
<!-- /Slider Setup -->

<?php if (get_option('woo_exclude') <> $exclude) update_option("woo_exclude", $exclude); ?>
