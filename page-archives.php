<?php
/*
Template Name: Archives
*/
get_header(); ?>

<section class="pd-archives-page">
  <h1 class="pd-archive-title"><?php esc_html_e('Archives','photodiary'); ?></h1>

  <div class="pd-archives-columns">
    <div>
      <h2><?php esc_html_e('By Year','photodiary'); ?></h2>
      <ul class="pd-archive-list">
        <?php wp_get_archives( ['type'=>'yearly'] ); ?>
      </ul>
    </div>
    <div>
      <h2><?php esc_html_e('By Month','photodiary'); ?></h2>
      <ul class="pd-archive-list">
        <?php wp_get_archives( ['type'=>'monthly'] ); ?>
      </ul>
    </div>
  </div>
</section>

<?php get_footer(); ?>
