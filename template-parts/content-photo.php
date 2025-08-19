<article id="post-<?php the_ID(); ?>" <?php post_class('photo-item'); ?>>
  <div class="polaroid">
    <?php
    // Make the entire image clickable to single post on index/archive pages
    if ( ! is_singular() ) {
      echo '<a href="' . esc_url( get_permalink() ) . '">';
    }
    
    // Force full-size image - multiple fallback methods
    if (has_post_thumbnail()) {
      // Method 1: Get the full size image URL directly
      $image_id = get_post_thumbnail_id();
      $image_data = wp_get_attachment_image_src($image_id, 'full');
      
      if ($image_data) {
        $image_url = $image_data[0];
        $image_width = $image_data[1];
        $image_height = $image_data[2];
        
        // Only use if it's a reasonable size (larger than typical thumbnails)
        if ($image_width > 600 || $image_height > 600) {
          echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr(get_the_title()) . '" loading="lazy">';
        } else {
          // Fallback: try to get original file URL
          $attachment_url = wp_get_attachment_url($image_id);
          if ($attachment_url) {
            echo '<img src="' . esc_url($attachment_url) . '" alt="' . esc_attr(get_the_title()) . '" loading="lazy">';
          } else {
            // Last resort: use whatever we have but add a warning comment
            echo '<!-- Warning: Small image detected (' . $image_width . 'x' . $image_height . ') - consider re-uploading -->';
            echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr(get_the_title()) . '" loading="lazy">';
          }
        }
      }
    } else {
      // Extract first image from content
      $content = get_the_content();
      if (preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $content, $matches)) {
        echo '<img src="' . esc_url($matches[1]) . '" alt="' . esc_attr(get_the_title()) . '">';
      }
    }
    
    // Close the link wrapper for images
    if ( ! is_singular() ) {
      echo '</a>';
    }
    ?>
    <div class="caption">
      <?php 
      // Only show title once, link to single post on index/archive pages
      if ( ! is_singular() ) {
        echo '<h2 class="photo-title"><a href="' . esc_url( get_permalink() ) . '">' . get_the_title() . '</a></h2>';
      } else {
        echo '<h1 class="photo-title">' . get_the_title() . '</h1>';
      }
      ?>
    </div>
  </div>
</article>