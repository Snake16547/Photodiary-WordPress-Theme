<?php
/**
 * Archive template
 *
 * @package Photodiary
 */
get_header();
?>

<header class="archive-header">
  <h2 class="archive-title">
    <?php 
    // Custom archive title without prefix
    if ( is_category() ) {
      single_cat_title();
    } elseif ( is_tag() ) {
      single_tag_title();
    } elseif ( is_author() ) {
      the_author();
    } elseif ( is_year() ) {
      echo get_the_date('Y');
    } elseif ( is_month() ) {
      echo get_the_date('F Y');
    } elseif ( is_day() ) {
      echo get_the_date('F j, Y');
    } else {
      the_archive_title();
    }
    ?>
  </h2>
</header>

<?php if ( have_posts() ) : ?>
  <div class="photo-feed">
    <?php while ( have_posts() ) : the_post(); ?>
      <?php get_template_part( 'template-parts/content', 'photo' ); ?>
    <?php endwhile; ?>
  </div>

  <div class="navigation">
    <?php
    if ( get_theme_mod('photodiary_infinite_scroll', true) ) {
      // Infinite scroll handled by JS
    } else {
      the_posts_pagination( array(
        'mid_size' => 2,
        'prev_text' => __('&laquo; Prev', 'photodiary'),
        'next_text' => __('Next &raquo;', 'photodiary'),
      ));
    }
    ?>
  </div>
<?php else : ?>
  <p><?php esc_html_e( 'No photos found.', 'photodiary' ); ?></p>
<?php endif; ?>

<?php get_footer(); ?>