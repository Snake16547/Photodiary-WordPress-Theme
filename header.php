<?php
/**
 * Header template
 *
 * @package Photodiary
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'photodiary' ); ?></a>

<header class="site-header">
  <!-- Site Title (center) -->
  <div class="site-branding">
    <?php the_custom_logo(); ?>
    <p class="site-title">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
        <?php bloginfo( 'name' ); ?>
      </a>
    </p>
  </div>

  <!-- Hamburger Menu Button (top right) -->
  <button type="button" class="menu-toggle-btn" id="menu-toggle-btn" aria-label="<?php esc_attr_e('Toggle Navigation Menu', 'photodiary'); ?>" aria-expanded="false" aria-controls="site-navigation" aria-haspopup="dialog" hidden>
    <span class="hamburger-line"></span>
    <span class="hamburger-line"></span>
    <span class="hamburger-line"></span>
  </button>

  <!-- Navigation Overlay -->
  <dialog id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Navigation', 'photodiary' ); ?>">
    <nav class="nav-content" aria-label="<?php esc_attr_e( 'Archives', 'photodiary' ); ?>">
      <button type="button" autofocus class="nav-close" id="nav-close" aria-label="<?php esc_attr_e('Close Menu', 'photodiary'); ?>">&times;</button>

      <ul class="nav-menu">
        <!-- Dark Mode Toggle - Now First -->
        <li class="menu-item menu-item-dark-mode">
          <div class="dark-mode-menu-item">
            <span class="menu-label"><?php esc_html_e('Dark Mode', 'photodiary'); ?></span>
            <label class="toggle-switch">
              <input type="checkbox" id="darkmode-toggle" aria-label="<?php esc_attr_e('Toggle Dark Mode', 'photodiary'); ?>">
              <span class="toggle-slider"></span>
            </label>
          </div>
        </li>

        <!-- Archive - Now Second and Centered -->
        <li class="menu-item menu-item-archive">
          <span class="archive-trigger"><?php esc_html_e('Archive', 'photodiary'); ?></span>
          <div class="archive-dropdown">
            <?php foreach ( photodiary_archive_months() as $year => $months ) : ?>
              <details class="archive-year">
                <summary class="year-button"><?php echo esc_html( $year ); ?></summary>
                <div class="archive-months">
                  <?php foreach ( $months as $month => $timestamp ) : ?>
                    <a href="<?php echo esc_url( get_month_link( $year, $month ) ); ?>">
                      <?php echo esc_html( wp_date( 'F', $timestamp ) ); ?>
                    </a>
                  <?php endforeach; ?>
                </div>
              </details>
            <?php endforeach; ?>
          </div>
        </li>
      </ul>
    </nav>
  </dialog>
</header>

<main id="content" class="site-content" tabindex="-1">
