<?php
/*
Template Name: Gallery Home
*/
?>
<?php
function break_array($array, $page_size) {
  
  $arrays = array();
  $i = 0;
  
  foreach ($array as $index => $item) {
    if ($i++ % $page_size == 0) {
      $arrays[] = array();
      $current = & $arrays[count($arrays)-1];
    }
    $current[] = $item;
  }
  
  return $arrays;
  
}
?>

<?php get_header(); ?>
<?php global $woo_options; ?>

<div id="sidepanel">
  <h2 class="sifr">Gallery</h2>
      <div class="search">
        <h3>search</h3>
        <div class="item">
          <p>Use the following form to search the gallery.</p>

        </div>
        <form action="/gallerysearch">
          <label>search term</label>
          <input id="text" name="q" type="text" />
          <input class="action" type="submit" value="click here to search" />
        </form>
      </div>
    </div>


    <div id="gallerycontent" class="clearfix">

  
<?php
$args = array( 'post_type' => 'gallery');
$posts = get_posts($args);
$rows = break_array($posts, 3);

foreach ($rows as $row) {
?>


<div class="threecolumnleft clearfix">
<?php
$count = 0;
foreach ($row as $post) {
	$count++;
	?>
   <div class="category c<?php echo $count; ?>">
     <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'single-post-thumbnail' ); ?></a>
     <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
   </div>
<?php
}
?>
   
</div>
<?php
}
?>  



    </div>



<?php get_footer(); ?>
       
