<?php
$show_featured = has_post_thumbnail() && ! post_password_required();
$frame_content = is_singular( 'post' ) && ! $show_featured && ! post_password_required();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'photo-item single-photo-item' ); ?>>
  <div class="polaroid">
    <?php if ( $show_featured ) : ?>
      <?php the_post_thumbnail( 'large' ); ?>
    <?php elseif ( $frame_content ) : ?>
      <div class="framed-entry-content">
        <?php the_content(); ?>
        <?php wp_link_pages(); ?>
      </div>
    <?php endif; ?>
    <div class="caption">
      <h1 class="photo-title"><?php the_title(); ?></h1>
    </div>
  </div>

  <?php if ( ! $frame_content ) : ?>
  <div class="entry-content">
    <?php the_content(); ?>
    <?php wp_link_pages(); ?>
  </div>
  <?php endif; ?>
</article>
