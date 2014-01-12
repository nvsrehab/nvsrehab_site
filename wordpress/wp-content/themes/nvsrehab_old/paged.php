<?php
/**
  News blog template
 */

get_header(); ?>
  <?php //show sidebar on the left
    if( $zAlive_options['primary_sidebar_layout'] == 2 ) { get_sidebar(); } 
  ?>
  echo "<div id='main'>";

 $my_query = new WP_Query( "category_name=news" );
   if ( $my_query->have_posts() ) {
     echo "<h2>News</h2>";
       while ( $my_query->have_posts() ) { 
           $my_query->the_post();
           the_content();
       }
   }
echo " </div>";
  <?php //show sidebar on the right
    if( $zAlive_options['primary_sidebar_layout'] == 1 ) { get_sidebar(); } 
  ?> 
  <?php get_footer(); 
?>