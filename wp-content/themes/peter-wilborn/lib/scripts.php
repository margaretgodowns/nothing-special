<?php
/**
 * Scripts and stylesheets
 *
 * Enqueue stylesheets in the following order:
 * 1. /theme/-/css/main.css
 *
 * Enqueue scripts in the following order:
 * 2. /theme/-/js/vendor/modernizr-2.7.0.min.js
 * 3. /theme/-/js/main.min.js (in footer)
 * 4. Google analytics (if not admin) (in footer)
 */

function fuzzco_scripts_init() {
  // Grab pretty css for Admins
  wp_enqueue_style('fuzzco_main', get_template_directory_uri() . '/style.min.css', false, filemtime(get_stylesheet_directory() . '/style.min.css'));

  if (!is_admin() && current_theme_supports('jquery-cdn')) {
    wp_deregister_script('jquery');
    wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js', array(), null, true);
    add_filter('script_loader_src', 'fuzzco_jquery_local_fallback', 10, 2);
  }

  if (is_single() && comments_open() && get_option('thread_comments')) {wp_enqueue_script('comment-reply'); }

  wp_register_script('modernizr', get_template_directory_uri() . '/-/js/vendor/modernizr.min.js', array(), false, false);
  wp_enqueue_script('modernizr');

  wp_enqueue_script('jquery');

  wp_register_script('fuzzco_scripts', get_template_directory_uri() . '/-/js/scripts.min.js', array(), filemtime(get_stylesheet_directory() . '/-/js/scripts.min.js'), true);
  wp_enqueue_script('fuzzco_scripts');

}
add_action('wp_enqueue_scripts', 'fuzzco_scripts_init');


// http://wordpress.stackexchange.com/a/12450
function fuzzco_jquery_local_fallback($src, $handle = null) {
  static $add_jquery_fallback = false;
  if ($add_jquery_fallback) {
    echo '<script>window.jQuery || document.write(\'<script src="' . get_template_directory_uri() . '/-/js/vendor/jquery.min.js"><\/script>\')</script>' . "\n";
    $add_jquery_fallback = false;
  }
  if ($handle === 'jquery') {
    $add_jquery_fallback = true;
  }
  return $src;
}
add_action('wp_head', 'fuzzco_jquery_local_fallback');


function google_analytics() { ?>
  <!-- Google Analytics -->
  <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', '<?php echo GOOGLE_ANALYTICS_ID; ?>', 'auto');
  ga('send', 'pageview');

  </script>
  <!-- End Google Analytics -->
<?php }

if (GOOGLE_ANALYTICS_ID && !current_user_can('manage_options')) {
  add_action('wp_footer', 'google_analytics', 20);
}
