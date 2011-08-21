<?php
/*
Template Name: Archives Page
*/
?>
<?php get_header(); ?>
       
    <div id="content" class="page col-full">
		<div id="main" class="col-left">
    	            
			<?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<div id="breadcrumb"><p>','</p></div>'); } ?>
			
			<div class="post" id="striped">
			    			    
			    <div class="entry" id="plate">
			    
		            <?php if (have_posts()) : the_post(); ?>
                    <div class="entry">
                    <h1 class="title"><?php the_title(); ?></h1>
	            	<?php the_content(); ?>
	            	</div>
		            <?php endif; ?>  
				    
				    <h3><?php _e('The Last 30 Posts', 'woothemes') ?></h3>
																	  
				    <ul>											  
				        <?php query_posts('showposts=30'); ?>		  
				        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				            <?php $wp_query->is_home = false; ?>	  
				            <li><a href="<?php the_permalink() ?>"><?php the_title(); ?></a> - <?php the_time( get_option( 'date_format' ) ); ?> - <?php echo $post->comment_count ?> <?php _e('comments', 'woothemes') ?></li>
				        <?php endwhile; endif; ?>					  
				    </ul>											  
					
					<div class="fl" style="width:50%">												  
					    <h3><?php _e('Categories', 'woothemes') ?></h3>	  
					    <ul>											  
					        <?php wp_list_categories('title_li=&hierarchical=0&show_count=1') ?>	
					    </ul>											  
					</div>				     												  

					<div class="fr" style="width:50%">												  
					    <h3><?php _e('Monthly Archives', 'woothemes') ?></h3>
																		  
					    <ul>											  
					        <?php wp_get_archives('type=monthly&show_post_count=1') ?>	
					    </ul>
					</div>		
					
					<div class="fix"></div>		     												  

				</div><!-- /.entry -->
			    			
			</div><!-- /.post -->                 
                
        </div><!-- /#main -->

        <?php get_sidebar(); ?>

    </div><!-- /#content -->
		
<?php get_footer(); ?>
