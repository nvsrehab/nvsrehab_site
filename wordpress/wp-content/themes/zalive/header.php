<?php
/**
 * default header template
 */
 get_template_part( 'template/header' );
 global $zAlive_options;
 $container_classes = '';
 $sidebar_layout_classes = '';
if(( $zAlive_options['primary_sidebar_layout'] == 1 ) && ( !is_front_page())){
   $sidebar_layout_classes = 'content-two-columns';    
 }elseif (( $zAlive_options['primary_sidebar_layout'] == 2 ) && ( !is_front_page())){
   $container_classes = 'container-sidebar-left';
   $sidebar_layout_classes = 'content-two-columns content-two-columns-sidebar-left';
 }else{
   $sidebar_layout_classes = 'content-full-width';
 }
?>
  <div id="content" class="container <?php echo $container_classes; ?>">
    <div class="<?php echo $sidebar_layout_classes; ?> clearfix">