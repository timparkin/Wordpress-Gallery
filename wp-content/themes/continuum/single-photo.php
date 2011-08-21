<?php get_header(); ?>
<?php global $woo_options; ?>
<?php
$photo = $post;
$temp = $wp_query;
$wp_query= null;
$wp_query = new WP_Query();
$query = new WP_Query(array( 'post_type' => 'gallery', 'connected_from' => $post->ID));
$gallerytitle = $query->posts[0]->post_name;
$galleryid = $query->posts[0]->ID;
$wp_query = new WP_Query( array( 'post_type' => 'photo', 'connected_to' => $galleryid));

	
$count = 0;
foreach ($wp_query->posts as $p) {
  if ($p->ID == $photo->ID	) {
	if ($count == 0) {
	    $prev = null;	
	} else {
		$prev = $wp_query->posts[$count-1];
	}
	if ( count($wp_query->posts) == $count ) {
	    $next = null;
	} else {
	    $next = $wp_query->posts[$count+1];
    }
  }
  $count ++;
}
//echo var_dump($wp_query->posts);
$count = 0;
$wp_query = $temp;
?>
<?php if (have_posts()) : $count = 0; ?>
<?php while (have_posts()) : the_post(); $count++; ?>

<div id="category">
  <h2 class="sifr"><?php echo $gallerytitle ?></h2>
  <h3 class="sifr">
    <?php the_title(); ?>
  </h3>
</div>
<div id="price"><a href="#" onclick="$('.purchase').toggle();$(this).toggleClass('over');return false;"> <img src="<?php echo get_template_directory_uri(); ?>/images/button-price-off-inverted.gif"/> </a></div>
<div id="info"><a href="#" onclick="$('.record').toggle();$(this).toggleClass('over');return false;"> <img src="<?php echo get_template_directory_uri(); ?>/images/button-info-off-inverted.gif"/> </a></div>
<div id="sidepanel" class="photo clearfix">
  <div class="purchase clearfix">
    <h3 onclick="$('.purchase').BlindToggleVertically(500, null, 'easeout');$('#price a').toggleClass('over');return false;">purchase options</h3>
  </div>
  <div class="record clearfix">
    <h3 onclick="$('.record').BlindToggleVertically(500, null, 'easeout');$('#info a').toggleClass('over');return false;">photographic record</h3>
    <dl>
      <dt>date</dt>
      <dd>30th October 2008</dd>
      <dt>location</dt>
      <dd>
      

      
      
<ul>
<?php 
$cats =  wp_get_post_terms($photo->ID,'location' );
$c = array();
foreach ($cats as $cat) {
  $c[] = $cat->name;	
}
echo join($c,', ')

 ?>
</ul>    
      
      </dd>
      <dt>lens</dt>
      <dd><?php echo slt_cf_field_value( "lens" ) ?></dd>
      <dt>speed</dt>
      <dd><?php echo slt_cf_field_value( "shutter_speed" ) ?></dd>
      <dt>aperture</dt>
      <dd><?php echo slt_cf_field_value( "aperture" ) ?></dd>

      <dt>keywords</dt>
      <dd>
<?php
$posttags = get_the_tags();
$t = array();
if ($posttags) {
  foreach ($posttags as $tag) {
    $t[] = $tag->name;	
  }
  echo join( $t, ', ' );
} else {
  echo '-';	
}
?>      
      
      </dd>
    </dl>
  </div>
  <div>
    <?php the_content(); ?>
  </div>
  <h2 class="sifr">Comments (<a href="#comment">skip to bottom</a>)</h2>
  <?php $comm = $woo_options['woo_comments']; if ( ($comm == "post" || $comm == "both") ) : ?>
  <?php comments_template('', true); ?>
  <?php endif; ?>
</div>
<div id="photo">
<div class="nextprev">
  <?php if ($prev): ?>
    <div class="nav-previous"><a href="<?php echo $prev->post_name; ?>">⇠ <?php echo $prev->post_title ?></a></div>
  <?php endif; ?>
  <?php if ($next): ?>
    <div class="nav-next"><a href="<?php echo $next->post_name; ?>"><?php echo $next->post_title ?> ⇢</a></div>
  <?php endif; ?>
</div>

  <div id="photobody"> <?php echo  get_the_post_thumbnail( $post->ID, 'medium' ) ?> </div>
</div>
<?php endwhile; else: ?>
<div class="body">
  <p>
    <?php _e('Sorry, no posts matched your criteria.', 'woothemes') ?>
  </p>
</div>
<?php endif; ?>
<?php get_footer(); ?>
