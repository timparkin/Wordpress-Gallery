<?php
/*
Template Name: Blog
*/
?>


<?php get_header(); ?>
<?php global $woo_options; ?>
<div id="blog" class="clearfix">
    <div id="blognav">
    </div>
    <div id="bloghead">
      <h2 class="sifr">Still Developing</h2>

      <div class="intro">
        <p>"
  A lot of my enjoyment of photography comes from learning. This is typically done through talking with others, reading books, magazine articles, blogs, etc. Part of the balance of having so much good information available (especially the writings that people make available for free online) is to contribute back by writing anything that I learn or experience. If you get something out of this great. If you care to comment to correct my many mistakes, I would greatly appreciate it. Landscape photography can be a lonely occupation but the conversations we have more than make up for that.
  "</p>
      </div>
    </div>
    <div id="sidepanel">
      <div class="search">
        <h3>search</h3>
        <div class="item">
          <p>Use the following form to search the blog.</p>
        </div>
        <form action="/search">
          <label>search term</label>
          <input type="text" name="q" id="text">
          <input type="submit" value="click here to search" class="action">
        </form>
        <h3>rss</h3>
        <div class="item">
          <p>Click <a href="/rss">here</a> to access my rss feed.</p>
          <p>Click <a href="/commentrss">here</a> to access the comment rss feed.</p>
        </div>
      </div>
    </div>
  </div>
<?php
			// WP 3.0 PAGED BUG FIX
			if ( get_query_var('paged') )
				$paged = get_query_var('paged');
			elseif ( get_query_var('page') ) 
				$paged = get_query_var('page');
			else 
				$paged = 1;
             query_posts("post_type=post&paged=$paged"); 
?>
   <?php if (have_posts()) : $count = 0; ?>
            <?php while (have_posts()) : the_post(); $count++; ?>


  <div class="blogitemsummary clearfix" n:render="blogentry">
    <div class="blogitemlabel">
    
      <div class="day"><?php the_time( 'l' ); ?></div>
      <div class="date"><?php the_time( 'j F Y' ); ?></div>
      <div class="numComments"><?php comments_number('No Comments', '1 Comment', '% Comments'); ?></div>
    
       
    </div>

    <div id="content">
      <h3 class="sifr"><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h3>
      <div class="body"> <?php if ( $woo_options['woo_post_content'] == "content" ) the_content(__('Read More...', 'woothemes')); else the_excerpt(); ?>
                                <span class="more"><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>">Click to view full post including <?php comments_number('No Comments', '1 Comment', '% Comments'); ?></a></span>

</div>
	 


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
            <?php woo_pagenav(); ?>


<?php get_footer(); ?>
       






