<?php
/**
 * common header template
 */
 global $zAlive_options;
?><!DOCTYPE html>
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php wp_head(); ?>
</head>
<body <?php body_class( ( is_home() && $zAlive_options['hide_posts_and_primary_sidebar'] == true ) ? 'hide_posts_and_primary_sidebar' : '' ); ?>>
  <div id="header">
    <div class="navbar container">
      <div class="navbar-inner">
	
        <?php $heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div'; ?>
				<<?php echo $heading_tag; ?> class="brand">
		
<img src="http://nvsrehab.org/wordpress_437746477/wp-content/uploads/2013/10/nvsrehab_logo.jpeg" class="nvslogo">          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" class="nvstitle"><?php bloginfo( 'name' ); ?></a>

        </<?php echo $heading_tag; ?>>
<form action="https://www.paypal.com/cgi-bin/webscr" style="margin-left:30px;" method="post" id="paypalbuttondiv">
	<input type="hidden" name="cmd" value="_s-xclick">
	<input type="hidden" name="hosted_button_id" value="3018416">
	<input type="image" src="http://nvsrehab.org/wordpress_437746477/wp-content/uploads/2013/10/TransButton_DonateRounded-2.png" border="0" name="submit" title="Donate now to our charity and help a really great organization enhance our clients' lives."class="button menubardonate" >
</form> 
        <ul class="nav">
          <?php 
            if ( has_nav_menu( 'top_nav_menu' ) ) {
              wp_nav_menu( array('theme_location'  => 'top_nav_menu', 'container' => '','depth' => 2 ,'items_wrap' => '%3$s' ) ); 
            } else {
              wp_list_categories('depth=2&title_li=0&orderby=id&show_count=0&number=6');
            }           
          ?>
	  <?php if( $zAlive_options['header_searchbox_enabled'] == true ) : ?><li id="searchboxli">
<form class="pull-right input-append" id="searchbox" method="get" action="<?php echo home_url( '/' ); ?>" >
          <input name="s" id="s" type="text" placeholder="<?php _e('Type and search...','zAlive'); ?>">
          <button type="submit" class="btn"><?php _e('Search','zAlive'); ?></button>
        </form>
        </li>
      <?php endif; ?>
        </ul>
     
      </div>
    </div>
  <?php if( $zAlive_options['show_tagline_directly'] == true ) : ?>
    <div id="site-description" class="tagline tagline-shown-directly container visible-desktop">
      <p><?php bloginfo('description'); ?></p>
    </div>
  <?php else : ?>
    <div id="site-description" class="tagline container visible-desktop">
      <p><?php bloginfo('description'); ?></p>
    </div>
  <?php endif; ?>
  </div>
  <?php //slider
    if( $zAlive_options['slider_enabled'] == 1 || ( $zAlive_options['slider_enabled'] == 2 && ( is_home() || is_front_page() ) ) ){
      get_template_part( 'template/slider' );
    }
  ?>