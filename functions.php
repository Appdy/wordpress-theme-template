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

if ( ! function_exists( 'adventure_setup' ) ) :

function adventure_setup() {

  /*
   * Add theme specific translations.
   */
  load_theme_textdomain( 'adventure' );

  // Limit max assets width.
  // add_theme_support( 'content-width' );
  // add_theme_support( 'post-formats' );

  add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'customize-selective-refresh-widgets' );
  add_theme_support( 'title-tag' );

  add_theme_support( 'custom-logo', array(
    'height' => 240,
    'width' => 240,
    'flex-height' => true
  ) );

  add_theme_support( 'post-thumbnails' );
  set_post_thumbnail_size( 1200, 9999 );

  register_nav_menus( array(
    'primary' => __( 'Primary Menu', 'adventure' ),
    'social' => __( 'Social Links Menu', 'adventure' )
  ) );
}
endif;
add_action( 'after_setup_theme', 'adventure_setup' );

function adventure_widget_init() {
  register_sidebar( array(
    'name' => __( 'Left Sidebar', 'adventure' ),
    'id' => 'sidebar-1',
    'description' => __( 'Add widgets here to appear in your left sidebar.', 'adventure' ),
    'before_widget' => '<section id="%1$s" class="widget %2$s">',
    'after_widget' => '</section>',
    'before_title' => '<h2 class="widget-title">',
    'after_title' => '</h2>'
  ) );

  register_sidebar( array(
    'name' => __( 'Right Sidebar', 'adventure' ),
    'id' => 'sidebar-2',
    'description' => __( 'Add widgets here to appear in your right sidebar.', 'adventure' ),
    'before_widget' => '<section id="%1$s" class="widget %2$s">',
    'after_widget' => '</section>',
    'before_title' => '<h2 class="widget-title">',
    'after_title' => '</h2>'
  ) );

  register_sidebar( array(
    'name' => __( 'Top Sidebar', 'adventure' ),
    'id' => 'sidebar-3',
    'description' => __( 'Apears at the top of the content of post and pages.', 'adventure' ),
    'before_widget' => '<section id="%1$s" class="widget %2$s">',
    'after_widget' => '</section>',
    'before_title' => '<h2 class="widget-title">',
    'after_title' => '</h2>'
  ) );

  register_sidebar( array(
    'name' => __( 'Bottom Sidebar', 'adventure' ),
    'id' => 'sidebar-4',
    'description' => __( 'Apears at the bottom of the content of post and pages.', 'adventure' ),
    'before_widget' => '<section id="%1$s" class="widget %2$s">',
    'after_widget' => '</section>',
    'before_title' => '<h2 class="widget-title">',
    'after_title' => '</h2>'
  ) );
}
add_action( 'widgets_init', 'adventure_widget_init' );

function adventure_scripts() {
  wp_enqueue_style( 'adventure-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'adventure_scripts' );

function adventure_body_classes( $classes ) {
  if ( is_multi_author() ) {
    $classes[] = 'group-blog';
  }

  if ( ! is_active_sidebar( 'sidebar-1' ) && ! is_active_sidebar( 'sidebar-2' ) ) {
    $classes[] = 'no-sidebar';
  }

  if ( ! is_singular() ) {
    $classes[] = 'hfeed';
  }

  return $classes;
}
add_action( 'body_class', 'adventure_body_classes' );

require get_template_directory() . '/inc/template-tags.php';

// require get_template_directory() . '/inc/customizer.php';

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images
 *
 * @since Twenty Sixteen 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function twentysixteen_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	840 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 62vw, 840px';

	if ( 'page' === get_post_type() ) {
		840 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
	} else {
		840 > $width && 600 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 61vw, (max-width: 1362px) 45vw, 600px';
		600 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'twentysixteen_content_image_sizes_attr', 10 , 2 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails
 *
 * @since Twenty Sixteen 1.0
 *
 * @param array $attr Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size Registered image size or flat array of height and width dimensions.
 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
 */
function twentysixteen_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( 'post-thumbnail' === $size ) {
		is_active_sidebar( 'sidebar-1' ) && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 60vw, (max-width: 1362px) 62vw, 840px';
		! is_active_sidebar( 'sidebar-1' ) && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 88vw, 1200px';
	}
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'twentysixteen_post_thumbnail_sizes_attr', 10 , 3 );

?>
