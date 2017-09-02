<?php
/**
 * Short description for header.php
 *
 * @package Wordpress
 * @author Adam Faryna <adamfaryna@appdy.net>
 * @version 0.1
 * @copyright (C) 2017 Adam Faryna <adamfaryna@appdy.net>
 * @license GNU GPL v3.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
  <?php endif; ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
  <div class="site-inner">
  <a href="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'adventure' ) ?></a>

  <header id="masthead" class="site-header" role="banner">
    <div class="site-header-main">
      <div class="site-branding">
        <?php adventure_the_custom_logo();  ?>

        <?php if ( is_front_page() && is_home() ) : ?>
          <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
        <?php else : ?>
          <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
        <?php endif;

        $description = get_bloginfo( 'description', 'display' );
        if ( $description || is_customize_preview() ) : ?>
          <p class="site-description"><?php echo $description; ?></p>
        <?php endif; ?>
        </div><!-- .site-branding -->

          <?php if ( has_nav_menu( 'primary' ) || has_nav_menu( 'social' ) ) : ?>
            <button id="menu-toggle" class="menu-toggle"><?php _e( 'Menu', 'adventure' ); ?></button>

            <div id="site-header-menu" class="site-header-menu">
            <?php ?>
</div>
</div>
</header>

</div>

</div>
</body>
</html>
