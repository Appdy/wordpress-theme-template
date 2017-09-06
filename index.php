<?php
/**
 * Short description for
 *
 * @package package
 * @author Adam Faryna <adamfaryna@appdy.net>
 * @version 0.1
 * @copyright (C) 2017 Adam Faryna <adamfaryna@appdy.net>
 * @license Proprietary
 */
?>
<?php get_header(); ?>

<div id="primary" class="content-area">
  <main id="main" class="site-main" role="main">
  <?php if ( have_posts() ) : ?>
  <?php if ( is_home() && ! is_front_page() ) : ?>
  <header>
  <h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
  </header>
  <?php endif; ?>

<?php
while ( have_posts() ) : the_post();
get_template_part( 'template-parts/content', get_post_format() );
endwhile;

the_posts_pagination( array(
  'prev_text' => __( 'Previous page', 'adventure' ),
      'next_text' => __( 'Next page', 'adventure' ),
      'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentysixteen' ) . ' </span>',
    ) );

// when no posts / content
else : get_template_part( 'template-parts/content', 'none' );
endif;
?>

</main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_sidebar(); ?>

    </div><!-- .site-content -->

<?php get_footer(); ?>
