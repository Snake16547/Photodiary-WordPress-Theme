<?php
/**
 * Single template
 *
 * @package Photodiary
 */
get_header();
?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
  <div class="photo-feed single-photo">
    <?php get_template_part( 'template-parts/content', 'single' ); ?>
  </div>

  <div class="diary-navigation">
    <div class="nav-previous">
      <?php 
      $prev_post = get_previous_post();
      if ($prev_post) {
        echo '<a href="' . get_permalink($prev_post) . '" class="diary-nav-btn diary-prev">';
        echo '<span class="nav-icon">←</span>';
        echo '<span class="nav-text">' . esc_html__('Yesterday', 'photodiary') . '</span>';
        echo '</a>';
      }
      ?>
    </div>
    <div class="nav-next">
      <?php 
      $next_post = get_next_post();
      if ($next_post) {
        echo '<a href="' . get_permalink($next_post) . '" class="diary-nav-btn diary-next">';
        echo '<span class="nav-text">' . esc_html__('Tomorrow', 'photodiary') . '</span>';
        echo '<span class="nav-icon">→</span>';
        echo '</a>';
      }
      ?>
    </div>
  </div>
<?php endwhile; endif; ?>

<?php get_footer(); ?>