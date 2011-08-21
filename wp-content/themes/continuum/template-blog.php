<?php
/*
Template Name: Blog
*/
?>
<?php get_header(); ?>
<?php global $woo_options; ?>

    <!-- #content Starts -->
	<?php woo_content_before(); ?>
    <div id="content" class="col-full">
    
        <!-- #main Starts -->
        <div id="main" class="col-left">      
                    
		<?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<div id="breadcrumb"><p>','</p></div>'); } ?>
        <?php 
			// WP 3.0 PAGED BUG FIX
			if ( get_query_var('paged') )
				$paged = get_query_var('paged');
			elseif ( get_query_var('page') ) 
				$paged = get_query_var('page');
			else 
				$paged = 1;
			//$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; 
       		 
             query_posts("post_type=post&paged=$paged"); 
        ?>
			<div id="striped">        
	        <?php if (have_posts()) : $count = 0; ?>
	                                                                    
				<div id="plate">
		        <?php while (have_posts()) : the_post(); $count++; ?>
		                                                                    
		            <!-- Post Starts -->
		            <div class="post arc">
		
		                <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
		
		                <?php if ( $woo_options['woo_post_content'] != "content" ) woo_get_image('image', '169', '123','fr'); ?>
		                <?php woo_post_meta(); ?>
		                
		                <div class="entry">
		                    <?php if ( $woo_options['woo_post_content'] == "content" ) the_content(__('Read More...', 'woothemes')); else the_excerpt(); ?>
		                </div><!-- /.entry -->
		
		                <div class="post-more"> 
							<span class="comment"><?php comments_popup_link(__('0 Comments','woothemes'), __('1 Comment','woothemes'), __('% Comments','woothemes'),'',''); ?></span>     
		                	<?php if ( $woo_options['woo_post_content'] == "excerpt" ) { ?>
				<span class="more"><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php _e('Read more','woothemes'); ?></a> &raquo;</span>
		                    <?php } ?>
		                </div>   
						<div class="clear"></div>
						
		            </div><!-- /.post -->
		            
		        <?php endwhile; ?>
		        </div><!-- /.plate --> 
	                                                
	        <?php else: ?>
	            <div class="post">
	                <p><?php _e('Sorry, no posts matched your criteria.', 'woothemes') ?></p>
	            </div><!-- /.post -->
	        <?php endif; ?>  
	        </div><!-- /#striped -->
    
            <?php woo_pagenav(); ?>
                
        </div><!-- /#main -->
            
		<?php get_sidebar(); ?>

    </div><!-- /#content -->    
		
<?php get_footer(); ?>