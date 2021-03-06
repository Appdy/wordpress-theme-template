<?php
/**
  * @package LightGlass theme
  * @author Adam Faryna
  * @version 0.1
  * @copyright (C) 2018 Appdy LTD
  * @license MIT
  */
?>

<footer id="colophon" class="site-footer" role="contentinfo">
  <?php if ( has_nav_menu( 'primary' ) ) : ?>
    <nav class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer PrimaryMenu', 'adventure' ); ?>">
      <?php
        wp_nav_menu( array(
          'theme_location' => 'primary',
          'menu_class'     => 'primary_menu',
        ) );
      ?>
    </nav><!-- .main-navigation -->
  <?php endif; ?>

  <?php if( has_nav_menu( 'social' ) ) : ?>
    <nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer Social Links Menu', 'adventure' ); ?>">
      <?php
        wp_nav_menu( array(
          'theme_location' => 'social',
          'menu_class'     => 'social-links-menu',
          'depth'          => 1,
          'link_before'    => '<span class="screen-reader-text">',
          'link_after'     => '</span>',
        ) );
      ?>
    </nav><!-- .social-navigation -->
  <?php endif; ?>

  <div class="site-info">
    <?php
      // display credits
      // do_action( 'action_name' );
    ?>
    <span class="site-title"><a href="<?php echo esc_url( home_url( '/') ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span>
    <a href="<?php echo esc_url( __( '' ) ) ?>"></a>
  </div><!-- .site-info -->


</footer><!-- .site-footer -->

<script src="https://code.jquery.com/jquery-{{JQUERY_VERSION}}.min.js" integrity="{{JQUERY_SRI_HASH}}" crossorigin="anonymous"></script>