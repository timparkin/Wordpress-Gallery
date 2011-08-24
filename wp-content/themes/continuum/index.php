<?php get_header(); ?>
<?php global $woo_options; ?>


    
    <div id="triptych">


<?php
$wp_query = new WP_Query( array( 'post_type' => 'photo', 'tag' => 'homepage_feature'));
?>
<?php if (have_posts()) : $count = -1; ?>
<?php while (have_posts()) : the_post(); $count++; ?><div class="photo item-<?php echo $count; ?>"><a href="<?php the_permalink(); ?>"><?php echo get_the_post_thumbnail( $post->ID, array(300,500), $attr ); ?></a></div><?php endwhile; else: ?>
<p><?php _e('Please tag featured images as "homepage_featured"'); ?></p>
<?php endif; ?>
    </div>
 
       <div>
<div class="content"><p>Tim Parkin has discovered landscape photography at a late age and is trying his best to make up for lost time. After a year spent with a digital SLR, his 40th birthday was a trip to the Hebrides in a viking long house with David Ward and Richard Childs (two of the best landscape photographers in the UK). The large format obsession that infected him over that week has culminated in a recent exhibit of one of his pictures at the National Theatre as part of the Landscape Photographer of the Year awards. Tim is looking forward to what surprises his third year in photography has in store. If you want to learn more about what makes Tim tick, you can read his blog and also a brief summary career history and path to landcape photographer in the about section.
</p>
<p>I've been posting lots of articles and have just created an index of them which you can view here. <a href="/articles">Landscape Photographer Articles</a>
</p>
<p>Images will soon be available for sale directly through the website. In the interim please contact us by phone or email. Alternatively, check the <a href="http://timparkin.co.uk/news">News page</a> or the <a href="http://timparkin.co.uk/blog">blog</a> for updates
</p>
<p>Tim primarily works in <a href="http://www.timparkin.co.uk/gallerysearch?q=yorkshire">Yorkshire</a> including the dales and some moors but has made a few visits to <a href="http://www.timparkin.co.uk/gallerysearch?q=scotland">Glencoe</a> in Scotland and <a href="http://www.timparkin.co.uk/gallerysearch?q=northumberland">Northumberland</a>. More pictures from the <a href="http://www.timparkin.co.uk/gallerysearch?q=peak%20district">Peak District</a> and <a href="http://www.timparkin.co.uk/gallerysearch?q=lake%20district">Lake District</a> soon.
</p>
</div>

</div>




  <div id="homepageblogsummary">
<h2 class="sifr">Latest Blog Posts</h2>
			<?php if ( $woo_options['woo_featured'] == "true" ) include(TEMPLATEPATH . '/includes/featured.php'); ?>

</div>
<div style="padding-top:20px" class="blogitemsummary">
<h2 class="sifr">Testimonials</h2>
<p><em>"We wanted to portray a professional image to our customers and so we acquired art by Joe Cornish, Graham Ibbeson, Ashley Jackson and Tim Parkin to enhance our restaurant and reception areas."</em> - <strong style="color: black">Three Albion Place, Leeds</strong></p>

<p><em>"As one of the world's largest <a href="http://www.betus.com/" class="text">sports betting</a> sites, we have a passion for great artists and creativity in many art forms. Tim Parkin has proven that his beautiful and realistic landscape photos deserve all the praise he can get and more! Thank you, Tim, for showing the world your work."</em> - <strong style="color: black">BetUS.com</strong></p>
</div>

  







<?php get_footer(); ?>
