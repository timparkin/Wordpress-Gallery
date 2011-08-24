<?php
/*
Template Name: Default with Sidebar
*/
?>

<?php get_header(); ?>
      

    
            <?php if (have_posts()) : $count = 0; ?>
            <?php while (have_posts()) : the_post(); $count++; ?>


    <div id="subnav">
      <ul></ul>
    </div>
    <div id="content">
      <h2 class="sifr"><?php the_title(); ?></h2>
      <div>
<?php the_content(); ?>
</div>
    </div>
    <div id="sidepanel">
<?php $key="sidebar"; echo get_post_meta($post->ID, $key, true); ?>
      <div>


</div>
    </div>

  

			<?php endwhile; else: ?>
                	<p><?php _e('Sorry, no posts matched your criteria.', 'woothemes') ?></p>
            <?php endif; ?>  


		
<?php get_footer(); ?>
