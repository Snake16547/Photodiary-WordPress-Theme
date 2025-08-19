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
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
  <!-- Site Title (center) -->
  <div class="site-branding">
    <h1 class="site-title">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
        <?php bloginfo( 'name' ); ?>
      </a>
    </h1>
  </div>

  <!-- Hamburger Menu Button (top right) -->
  <button class="menu-toggle-btn" id="menu-toggle-btn" aria-label="<?php esc_attr_e('Toggle Navigation Menu', 'photodiary'); ?>" aria-expanded="false">
    <span class="hamburger-line"></span>
    <span class="hamburger-line"></span>
    <span class="hamburger-line"></span>
  </button>

  <!-- Navigation Overlay -->
  <nav id="site-navigation" class="main-navigation" aria-hidden="true">
    <div class="nav-content">
      <button class="nav-close" id="nav-close" aria-label="<?php esc_attr_e('Close Menu', 'photodiary'); ?>">&times;</button>
      
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
            <?php global $wpdb;
            $years = $wpdb->get_col("SELECT DISTINCT YEAR(post_date) FROM $wpdb->posts WHERE post_status='publish' AND post_type='post' ORDER BY post_date DESC");
            foreach($years as $year) {
              echo "<div class='archive-year'>";
              echo "<button class='year-button' data-year='$year'>$year</button>";
              echo "<div class='archive-months' id='months-$year'>";
              $months = $wpdb->get_results("SELECT DISTINCT MONTH(post_date) as month FROM $wpdb->posts WHERE post_status='publish' AND post_type='post' AND YEAR(post_date)=$year ORDER BY post_date DESC");
              foreach($months as $m) {
                $month_name = date_i18n("F", mktime(0,0,0,$m->month,1));
                echo '<a href="'. get_month_link($year, $m->month) .'">'. $month_name .'</a>';
              }
              echo "</div></div>";
            }
            ?>
          </div>
        </li>
      </ul>
    </div>
  </nav>
</header>

<main id="content" class="site-content">