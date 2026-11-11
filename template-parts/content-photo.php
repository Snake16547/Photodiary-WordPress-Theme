<article id="post-<?php the_ID(); ?>" <?php post_class( 'photo-item' ); ?>>
  <div class="polaroid">
    <a class="photo-link" href="<?php the_permalink(); ?>" aria-labelledby="photodiary-title-<?php the_ID(); ?>">
      <?php if ( ! post_password_required() ) : ?>
        <?php if ( has_post_thumbnail() ) : ?>
          <?php the_post_thumbnail( 'large' ); ?>
        <?php else : ?>
          <?php
          $content = get_the_content();
          if ( preg_match( '/<img\s[^>]*?\ssrc\s*=\s*(["\'])(.*?)\1/is', $content, $matches ) ) :
            ?>
            <img src="<?php echo esc_url( $matches[2] ); ?>" alt="">
          <?php endif; ?>
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
