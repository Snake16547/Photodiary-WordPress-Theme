<?php
/**
 * Index template
 *
 * @package Photodiary
 */
get_header();
?>

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