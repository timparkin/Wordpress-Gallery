<?php get_header(); ?>
<?php global $woo_options; ?>
       
    <div id="content" class="col-full">
		<div id="main" class="col-left">
            
			<div id="striped">                
			<?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<div id="breadcrumb"><p>','</p></div>'); } ?>
			<?php if (have_posts()) : $count = 0; ?>

            
	            <span class="archive_header"><?php _e('Search results', 'woothemes') ?> for <?php printf(the_search_query());?></span>
	            <div class="clear"></div>

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
            
				<div id="plate">
	                <div class="post arc">
	                    <p><?php _e('Sorry, no posts matched your criteria.', 'woothemes') ?></p>
	                </div><!-- /.post -->
		        </div><!-- /.plate --> 
            
            <?php endif; ?>  
	        </div><!-- /#striped -->
        		
			<?php woo_pagenav(); ?>

        </div><!-- /#main -->
            
		<?php get_sidebar(); ?>

    </div><!-- /#content -->    
		
<?php get_footer(); ?>