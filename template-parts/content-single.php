<article id="post-<?php the_ID(); ?>" <?php post_class('photo-item single-photo-item'); ?>>
  <div class="polaroid">
    <?php
    // Get the original full-size image
    if (has_post_thumbnail()) {
      // Get the full size image URL directly
      $image_id = get_post_thumbnail_id();
      $image_url = wp_get_attachment_image_src($image_id, 'full')[0];
      echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr(get_the_title()) . '">';
    } else {
      // Extract first image from content
      $content = get_the_content();
      if (preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $content, $matches)) {
        echo '<img src="' . esc_url($matches[1]) . '" alt="' . esc_attr(get_the_title()) . '">';
      }
    }
    ?>
    <div class="caption">
      <h1 class="photo-title"><?php the_title(); ?></h1>
    </div>
  </div>
</article>