<?php
/*
Template Name: Sitemap
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

					<div class="fl" style="width:50%">												  
	            	<h3><?php _e('Pages', 'woothemes') ?></h3>
	            	<ul>
	           	    	<?php wp_list_pages('depth=0&sort_column=menu_order&title_li=' ); ?>		
	            	</ul>
	            	</div>				
	    
					<div class="fl" style="width:50%">												  	    
		            <h3><?php _e('Categories', 'woothemes') ?></h3>
		            <ul>
	    	            <?php wp_list_categories('title_li=&hierarchical=0&show_count=1') ?>	
	        	    </ul>
	        	    </div>
	        	    <div class="fix"></div>
			        
			        <h3><?php _e('Posts per category','woothemes'); ?></h3>
			        <?php
			    
			            $cats = get_categories();
			            foreach ($cats as $cat) {
			    
			            query_posts('cat='.$cat->cat_ID);
			
			        ?>
	        
	        			<h4><?php echo $cat->cat_name; ?></h4>
			        	<ul>	
	    	        	    <?php while (have_posts()) : the_post(); ?>
	        	    	    <li style="font-weight:normal !important;"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a> - <?php _e('Comments', 'woothemes') ?> (<?php echo $post->comment_count ?>)</li>
	            		    <?php endwhile;  ?>
			        	</ul>
	    
	    		    <?php } ?>
	    		
	    		</div><!-- /.entry -->
	    						
	        </div><!-- /.post -->                    
	                
        </div><!-- /#main -->

        <?php get_sidebar(); ?>

    </div><!-- /#content -->
		
<?php get_footer(); ?>
