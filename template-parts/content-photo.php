<article id="post-<?php the_ID(); ?>" <?php post_class( 'photo-item' ); ?>>
  <div class="polaroid">
    <a class="photo-link" href="<?php the_permalink(); ?>" aria-labelledby="photodiary-title-<?php the_ID(); ?>">
      <?php if ( ! post_password_required() ) : ?>
        <?php if ( has_post_thumbnail() ) : ?>
          <?php the_post_thumbnail( 'large' ); ?>
        <?php else : ?>
          <?php
          // Shortcodes and blocks can generate the photo during content rendering.
          $content = apply_filters( 'the_content', get_the_content() );
          foreach ( wp_html_split( $content ) as $tag ) {
            if ( ! preg_match( '/^<img\b/i', $tag ) ) {
              continue;
            }
            // Prefer the real URL when an image optimizer supplies a placeholder.
            foreach ( array( 'data-src', 'src' ) as $attribute ) {
              $pattern = '/\s' . $attribute . '\s*=\s*(?:"([^"]*)"|\'([^\']*)\'|([^\s>]+))/i';
              if ( preg_match( $pattern, $tag, $matches ) ) {
                $url = html_entity_decode( $matches[1] ?: ( $matches[2] ?? '' ) ?: ( $matches[3] ?? '' ), ENT_QUOTES, 'UTF-8' );
                if ( esc_url( $url ) ) {
                  echo '<img src="' . esc_url( $url ) . '" alt="" loading="lazy">';
                  break 2;
                }
              }
            }
          }
          ?>
        <?php endif; ?>
      <?php endif; ?>

      <div class="caption">
        <h2 id="photodiary-title-<?php the_ID(); ?>" class="photo-title">
          <?php echo esc_html( get_the_title() ?: __( 'Untitled', 'photodiary' ) ); ?>
        </h2>
      </div>
    </a>
  </div>
</article>
