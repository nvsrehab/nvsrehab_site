<?php
/**
  page template
 */

get_header(); ?>
  <?php //show sidebar on the left
  if(( $zAlive_options['primary_sidebar_layout'] == 2 ) && ( !is_front_page() )) { get_sidebar(); } 
  ?>
    <div id="main">
       
      <?php if( $zAlive_options['breadcrumb_enabled'] == true ) {zAlive_breadcrumb();} ?>
      <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
      <div id="post-<?php the_ID(); ?>" <?php post_class( array('article','clearfix') ); ?>>

      <?php if ( is_front_page() ) { ?>
      <h1 class="entry-title"><?php //the_title(); ?></h1>
      <?php } else { ?>
      <h1 class="entry-title"><?php the_title(); ?></h1>
      <?php } ?>

        <?php get_template_part( 'template/entry-meta-primary','page' ); ?>
        <div class="entry-content clearfix">
          <?php the_content(); ?>
          <?php wp_link_pages( array( 'before' => '<div class="content-pager clearfix"><span class="pager_text">' . __( 'Pages: ', 'zAlive' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
        </div>
      </div>
        <?php wp_reset_postdata();
        endwhile; ?>
      <?php else : ?>
        <?php get_template_part( 'template/content', 'none' ); ?>
      <?php endif; ?>
      <?php if(comments_open()) {comments_template( '', true );}  ?>
    </div>
  <?php //show sidebar on the right
    if( $zAlive_options['primary_sidebar_layout'] == 1 ) { get_sidebar(); } 
  ?> 


<?php if (is_front_page() ) :  ?>
<div id="front_page_pre_footer">
  <div id="news">
     <?php $cat_name = "News";
           $category_id = get_cat_ID( $cat_name ); 
           $url = "";
           if ($category_id !=0):
             $url = get_category_link( $category_id ); 
           ?><h2><a href="<?php echo $url ?>">NEWS</a></h2> 
     <?php else : ?>
             <h2>NEWS</h2>    
     <?php endif;?> 

     <?php  \john\display_recent_news_excerpts(2) ?>
   </div>
    <div id="pre_footer_links"><?php 
        \john\display_pre_footer_links();
    ?></div>
    <div id="pre_footer_accreditation"><?php 
        \pete\display_post_footer_accred();
    ?></div>
    <div style="clear:both;"></div>
</div>
<?php endif;?>

  <?php get_footer(); ?>