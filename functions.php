<?php
/**
 * Theme functions
 *
 * @package Photodiary
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

function photodiary_scripts() {
    $version = wp_get_theme( get_template() )->get( 'Version' );
    wp_enqueue_style( 'photodiary-inter', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap', array(), null );
    wp_enqueue_style( 'photodiary-polaroid', get_theme_file_uri( 'assets/css/polaroid.css' ), array(), $version );
    wp_enqueue_style( 'photodiary-darkmode', get_theme_file_uri( 'assets/css/darkmode.css' ), array(), $version );
    wp_enqueue_style( 'photodiary-style', get_stylesheet_uri(), array( 'photodiary-inter', 'photodiary-polaroid', 'photodiary-darkmode' ), $version );
    wp_enqueue_script( 'photodiary-darkmode', get_theme_file_uri( 'assets/js/darkmode.js' ), array(), $version, true );

    if ( ( is_home() || is_archive() ) && ! is_paged() && get_theme_mod( 'photodiary_infinite_scroll', true ) ) {
        wp_enqueue_script( 'photodiary-infinite', get_theme_file_uri( 'assets/js/infinite-scroll.js' ), array( 'jquery' ), $version, true );
    }
}
add_action( 'wp_enqueue_scripts', 'photodiary_scripts' );

function photodiary_setup() {
    // Make theme available for translation
    load_theme_textdomain( 'photodiary', get_template_directory() . '/languages' );

    // Add theme support
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script'
    ) );

    // Add support for responsive embeds
    add_theme_support( 'responsive-embeds' );

    // Add support for custom logo
    add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ) );
}
add_action( 'after_setup_theme', 'photodiary_setup' );

// Customizer options
function photodiary_customize_register( $wp_customize ) {
  $wp_customize->add_section( 'photodiary_options', array(
    'title' => __( 'Photodiary Options', 'photodiary' ),
    'priority' => 30,
  ));

  $wp_customize->add_setting( 'photodiary_infinite_scroll', array(
    'default' => true,
    'sanitize_callback' => 'wp_validate_boolean',
    'transport' => 'refresh',
  ));

  $wp_customize->add_control( 'photodiary_infinite_scroll', array(
    'type' => 'checkbox',
    'section' => 'photodiary_options',
    'label' => __( 'Enable Infinite Scroll', 'photodiary' ),
    'description' => __( 'When disabled, pagination buttons will be shown instead.', 'photodiary' ),
  ));
}
add_action( 'customize_register', 'photodiary_customize_register' );

/**
 * Group published post dates for the navigation archive.
 *
 * @return array Years and their published months, newest first.
 */
function photodiary_archive_months() {
    $posts = new WP_Query( array(
        'post_type'              => 'post',
        'post_status'            => 'publish',
        'posts_per_page'         => -1,
        'ignore_sticky_posts'    => true,
        'no_found_rows'          => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
    ) );

    $years = array();
    foreach ( $posts->posts as $archive_post ) {
        $date = get_post_datetime( $archive_post );
        if ( $date ) {
            $years[ $date->format( 'Y' ) ][ $date->format( 'n' ) ] = $date->getTimestamp();
        }
    }

    return $years;
}
