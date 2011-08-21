<?php get_header(); ?>
<?php global $woo_options; ?>


   <?php if (have_posts()) : $count = 0; ?>
            <?php while (have_posts()) : the_post(); $count++; ?>


  <div class="blogitemsummary clearfix" n:render="blogentry">
    <div class="blogitemlabel">
    
      <div class="day"><?php the_time( 'l' ); ?></div>
      <div class="date"><?php the_time( 'j F Y' ); ?></div>
      <div class="numComments"><?php comments_number('No Comments', '1 Comment', '% Comments'); ?></div>
    
       
    </div>

    <div id="content">
      <h3 class="sifr"><?php the_title(); ?></h3>
      <div class="body"><?php the_content(); ?></div>
      <h2 class="sifr">Comments (<a href="#comment">skip to bottom</a>)</h2>
      <?php $comm = $woo_options['woo_comments']; if ( ($comm == "post" || $comm == "both") ) : ?>
                <?php comments_template('', true); ?>
            <?php endif; ?>  
	 


    </div>
    <div id="sidepanel">
    	<?php $key="sidebar"; echo get_post_meta($post->ID, $key, true); ?>
    </div>      
  </div>

		<?php endwhile; else: ?>
				
                
  <div class="blogitemsummary clearfix">
    <div id="content">
      <div class="body">
      	<p><?php _e('Sorry, no posts matched your criteria.', 'woothemes') ?></p>
      </div>
    </div>
    <div id="sidepanel">
    </div>      
  </div>                
                
           	<?php endif; ?>  


<?php get_footer(); ?>
       