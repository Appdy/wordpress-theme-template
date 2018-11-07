<?php
/**
  * @package LightGlass theme
  * @author Adam Faryna
  * @version 0.1
  * @copyright (C) 2018 Appdy LTD
  * @license MIT
  */
?>

<?php if ( is_active_sidebar( 'sidebar-bottom' ) ) : ?>
  <aside id="secondary" class="sidebar widget-area" role="complementary">
    <?php dynamic_sidebar( 'sidebar-bottom' ); ?>
  </aside><!-- .sidebar .widget-area -->
<?php endif; ?>
