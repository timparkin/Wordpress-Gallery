<?php
/*
Template Name: Image Gallery
*/
?>

<?php get_header(); ?>
       
    <div id="content" class="page col-full">
		<div id="main" class="col-left">
                                                                            
			<?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<div id="breadcrumb"><p>','</p></div>'); } ?>
            <div class="post" id="striped">

			<div id="plate">
                
				<div class="entry">

		            <?php if (have_posts()) : the_post(); ?>
                    <div class="entry">
                    <h1 class="title"><?php the_title(); ?></h1>
	            	<?php the_content(); ?>
	            	</div>
		            <?php endif; ?>  

                <?php query_posts('showposts=60'); ?>
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>				
                    <?php $wp_query->is_home = false; ?>

                    <?php woo_get_image('image',100,100,'thumbnail alignleft'); ?>
                
                <?php endwhile; endif; ?>	
                </div>
            <div class="fix"></div>                

            </div></div><!-- /.post -->
            <div class="fix"></div>                
		</div><!-- /#main -->
		
        <?php get_sidebar(); ?>

    </div><!-- /#content -->
		
<?php get_footer(); ?>