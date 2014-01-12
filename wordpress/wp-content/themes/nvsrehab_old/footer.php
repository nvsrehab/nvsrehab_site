<?php
/**
 * footer template
 */
 global $zAlive_options;
?>
      </div>
    </div>
    <?php 
      //sidebar secondary (footer_widgets.php is replaced with sidebar-secondary.php in version 1.2.2, but the option $zAlive_options['footer_widget_enabled'] is still exist)
      if( $zAlive_options['footer_widget_enabled'] == 1 || ($zAlive_options['footer_widget_enabled'] == 2 && ( is_home() || is_front_page() ) ) ){
        get_sidebar( 'secondary' ); 
      }
    ?>
    <div id="footer">
        <?php 
        \radu\footerText();
        ?>
    </div>
    <?php wp_footer(); ?>
</body>
</html>