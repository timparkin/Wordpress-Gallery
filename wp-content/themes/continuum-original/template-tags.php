<?php
/*
Template Name: Tags
*/
?>

<?php get_header(); ?>
       
    <div id="content" class="page col-full">
		<div id="main" class="fullwidth">
            
			<?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<div id="breadcrumb"><p>','</p></div>'); } ?>
                                                                        
                <div class="post" id="striped">

                    		
			<div id="plate">

		            <?php if (have_posts()) : the_post(); ?>
	            	<div class="entry">
	                    <h1 class="title"><?php the_title(); ?></h1>
	            		<?php the_content(); ?>
	            	</div>	            	
		            <?php endif; ?>  
		            
                    <div class="tag_cloud">
            			<?php wp_tag_cloud('number=0'); ?>
        			</div>

                </div></div><!-- /.post -->
        
		</div><!-- /#main -->
		
    </div><!-- /#content -->
		
<?php get_footer(); ?>