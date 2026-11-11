<article id="post-<?php the_ID(); ?>" <?php post_class( 'photo-item single-photo-item' ); ?>>
  <div class="polaroid">
    <?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
      <?php the_post_thumbnail( 'large' ); ?>
    <?php endif; ?>
    <div class="caption">
      <h1 class="photo-title"><?php the_title(); ?></h1>
    </div>
  </div>

  <div class="entry-content">
    <?php the_content(); ?>
    <?php wp_link_pages(); ?>
  </div>
</article>
