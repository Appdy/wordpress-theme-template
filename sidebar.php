<?php
/**
  * @package package
  * @author devil <adamfaryna@appdy.net>
  * @version 0.1
  * @copyright (C) 2017 Adam Faryna <adamfaryna@appdy.net>
  * @license GNU GPL v3.0
  */
?>

<?php if ( is_active_sidebar( 'sidebar_1' ) ) : ?>
  <aside id="secondary" class="sidebar widget-area" role="complementary">
    <?php dynamic_sidebar( 'sidebar-1' ); ?>
  </aside><!-- .sidebar .widget-area -->
<?php endif; ?>
