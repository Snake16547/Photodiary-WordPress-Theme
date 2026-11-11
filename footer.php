<?php
/**
 * Footer template
 *
 * @package Photodiary
 */
?>
</main>

<footer class="site-footer">
  <div class="footer-content">
    <p>&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?></p>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>