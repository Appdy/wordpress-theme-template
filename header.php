<?php
/**
  * @package LightGlass theme
  * @author Adam Faryna
  * @version 0.1
  * @copyright (C) 2018 Appdy LTD
  * @license MIT
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
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css"> -->
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<script src="js/vendor/modernizr-{{MODERNIZR_VERSION}}.min.js"></script>

<div id="page" class="hfeed site">
  <div class="site-inner">
    <a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'adventure' ); ?></a>

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
              <?php if ( has_nav_menu( 'primary' ) ) : ?>
                <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'adventure' ); ?>">
                <?php
                  wp_nav_menu( array(
                    'theme_location'  => 'primary',
                    'menu_class' => 'primary_menu'
                  ) );
                ?>
              </nav><!-- .main-navigation -->
              <?php endif; ?>

            <?php if ( has_nav_menu( 'social' ) ) : ?>
              <nav id="social_navigation" class="social_navigation" role="navigation" aria-label="<?php esc_attr_e( 'Social Links Menu', 'adventure' ); ?>">
                <?php
                  wp_nav_menu( array(
                    'theme_location' => 'social',
                    'menu_close' => 'social-links-menu',
                    'depth' => 1,
                    'link_before' => '<span class="screen-reader-text">',
                    'link_after' => '</span>'
                  ) );
                ?>
              </nav><!-- .social-navigation -->
            <?php endif; ?>
          </div><!-- .site-header-menu -->
        <?php endif; ?>
      </div><!-- .site-header-main -->

      <!-- display top sidebar -->
      <?php get_sidebar( 'sidebar-top' ); ?>

      <?php if ( get_header_image() ) : ?>
        <?php
          $custom_header_sizes = apply_filters( 'adventure_custom_header_sizes', '(max-width: 709px) 85vw, (max-width: 909px) 81vw, (max-width: 1362px) 88vw, 1200px' );
        ?>
        <div class="header-image">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?> " rel="home">
            <img src="<?php header_image(); ?>" srcset="<?php echo esc_attr( wp_get_attachment_image_srcset( get_custom_header()->attachment_id ) ); ?>" sizes="<?php echo esc_attr( $custom_header_sizes ); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
          </a>
        </div><!-- .header-image -->
        <?php endif; ?>
      </header><!-- .site-header -->

      <div id="content" class="site-content">
