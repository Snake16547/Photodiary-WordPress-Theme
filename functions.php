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
    wp_enqueue_style( 'photodiary-style', get_stylesheet_uri(), array(), wp_get_theme()->get('Version') );
    wp_enqueue_script( 'photodiary-darkmode', get_template_directory_uri() . '/assets/js/darkmode.js', array(), wp_get_theme()->get('Version'), true );
    
    // Only enqueue infinite scroll if option is enabled
    if ( get_theme_mod('photodiary_infinite_scroll', true) ) {
        wp_enqueue_script( 'photodiary-infinite', get_template_directory_uri() . '/assets/js/infinite-scroll.js', array('jquery'), wp_get_theme()->get('Version'), true );
        wp_localize_script('photodiary-infinite', 'photodiary_infinite', array(
          'max' => $GLOBALS['wp_query']->max_num_pages
        ));
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
    
    // Add support for editor styles
    add_theme_support( 'editor-styles' );
    
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

// Security: Remove WordPress version number
remove_action('wp_head', 'wp_generator');

// Add custom image sizes
function photodiary_image_sizes() {
    add_image_size( 'photodiary-large', 1200, 800, false );
}
add_action( 'after_setup_theme', 'photodiary_image_sizes' );

// Force high-quality images and regenerate thumbnails function
function photodiary_force_full_size_images() {
    // Hook to force full-size images when uploading
    add_filter('wp_image_editors', function($editors) {
        // Ensure we use the highest quality
        return $editors;
    });
    
    // Increase JPEG quality to maximum
    add_filter('jpeg_quality', function($quality) {
        return 100;
    });
    
    // Increase WebP quality to maximum
    add_filter('wp_editor_set_quality', function($quality, $mime_type) {
        return 100;
    }, 10, 2);
    
    // Force WordPress to prefer larger image sizes
    add_filter('wp_calculate_image_srcset_meta', '__return_null');
    
    // Remove WordPress's automatic image size selection
    add_filter('wp_calculate_image_srcset', '__return_false');
}
add_action('init', 'photodiary_force_full_size_images');

// Disable responsive image srcset completely for theme
function photodiary_disable_responsive_images() {
    add_filter('wp_calculate_image_srcset', '__return_false');
    add_filter('wp_calculate_image_sizes', '__return_false');
}
add_action('after_setup_theme', 'photodiary_disable_responsive_images');

// Force attachment images to use original size in theme
function photodiary_force_original_image_size($html, $attachment_id, $size, $icon, $attr) {
    if (is_admin()) {
        return $html; // Don't interfere with admin
    }
    
    // Get the original image URL
    $image_url = wp_get_attachment_image_src($attachment_id, 'full');
    if ($image_url) {
        $alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
        $html = '<img src="' . esc_url($image_url[0]) . '" alt="' . esc_attr($alt) . '" />';
    }
    
    return $html;
}
add_filter('wp_get_attachment_image', 'photodiary_force_original_image_size', 10, 5);

// Add admin notice for thumbnail regeneration with more specific instructions
function photodiary_admin_notice() {
    if (current_user_can('manage_options')) {
        $screen = get_current_screen();
        if ($screen && ($screen->id === 'themes' || $screen->id === 'appearance_page_theme-options')) {
            echo '<div class="notice notice-warning is-dismissible">';
            echo '<h3>' . __('Photodiary Theme - Image Quality Notice', 'photodiary') . '</h3>';
            echo '<p><strong>' . __('Important:', 'photodiary') . '</strong> ';
            echo __('This theme displays full-size images for best quality. If you see small/blurry images:', 'photodiary');
            echo '</p><ol>';
            echo '<li>' . __('Install the "Regenerate Thumbnails" plugin', 'photodiary') . '</li>';
            echo '<li>' . __('Go to Tools → Regenerate Thumbnails', 'photodiary') . '</li>';
            echo '<li>' . __('Click "Regenerate All Thumbnails"', 'photodiary') . '</li>';
            echo '<li>' . __('For stubborn images, try "Force Regenerate Thumbnails" plugin instead', 'photodiary') . '</li>';
            echo '</ol>';
            echo '<p>' . __('Alternative: Re-upload problematic images to ensure full quality.', 'photodiary') . '</p>';
            echo '</div>';
        }
    }
}
add_action('admin_notices', 'photodiary_admin_notice');