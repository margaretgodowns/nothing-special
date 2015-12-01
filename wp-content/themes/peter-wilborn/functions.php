<?php

/* ---------------------------------------------

Initialization

--------------------------------------------- */

if (!function_exists('fuzzco_init')):

  function fuzzco_init() {
  	wp_deregister_script('comment-reply');
  	remove_action('wp_head', 'wp_generator');
  	remove_action('wp_head', 'wlwmanifest_link');
  	remove_action('wp_head', 'feed_links_extra', 3);
  	remove_action('wp_head', 'feed_links', 2);
  }
  add_action('init', 'fuzzco_init');

endif;

if (!function_exists('fuzzco_setup')):

  function fuzzco_setup() {
  	add_theme_support('post-thumbnails');
  	add_theme_support('automatic-feed-links');

    /* Instagram API */
    /* 
    Follow the instructions here to get keys:
    https://bitbucket.org/fuzzco/snippets/src/4890193777258cec7798140a78c858bf662abaa2/api/instagram.md
    */
    /*
    include('-/api/instagram/FuzzcoInstagram.php');
    global $instagram;
    $config = array();
    $config['apiKey'] = '07af069ae5674db3bcf5f34ba05ea3bd';
    $config['apiSecret'] = 'b9021615ecf649caba7383887e880fa7';
    $config['apiCallback'] = 'http://fuzzco.com';
    $instagram = new FuzzcoInstagram($config);
    $instagram->setAccessToken('247885158.07af069.b7228672d6c347b8a77fe6f04e4f6f6a');
    */

    /* Twitter API */
    /* 
    These keys should work for any twitter account (read only)
    */
    /*
    include('-/api/twitter/FuzzcoTwitter.php');
    global $twitter;
    $userToken = '139107760-lrBbI8WuNhreXn0LfNiiTmWSkkVet2ZmFtZpo28g';
    $userSecret = 'mQe1TkGgcvcVETfne1lW51yEUoZksMihF83G7ITV5o';
    $twitter = new FuzzcoTwitter($userToken,$userSecret);
    */

  }
  add_action('after_setup_theme', 'fuzzco_setup');

endif;


/* ---------------------------------------------

Scripts

--------------------------------------------- */

if (!function_exists('fuzzco_footer')) :

  function fuzzco_footer() {
  	echo '<script type="text/javascript">
  	     var templateDirectory = \''.get_template_directory_uri().'/\';
  	     var homeURL = \''.home_url().'/\';
  	     </script>';
  }
  add_action('wp_footer', 'fuzzco_footer');

endif;


/* ---------------------------------------------

Optional Modifications

--------------------------------------------- */

// Modify Excerpt Ending
if (!function_exists('fuzzco_the_excerpt')) :
  function fuzzco_the_excerpt($text) {
  	return str_replace('[...]', '...', $text);
  }
  //add_filter('the_excerpt', 'fuzzco_the_excerpt');
endif;

// Modify Excerpt Length
  if (!function_exists('fuzzco_excerpt_length')) :
  function fuzzco_excerpt_length($length) {
  	return 16;
  }
  //add_filter('excerpt_length', 'fuzzco_excerpt_length');
endif;

// Modify Page Description
if (!function_exists('fuzzco_description')) :
  function fuzzco_description() {
  	global $page, $paged;
  	wp_title('|', true, 'right');
  	$site_description = get_bloginfo('description', 'display');
  	if ($site_description && !is_home() && !is_front_page())
  		echo ' | ' . $site_description;
  	if ($paged >= 2 || $page >= 2)
  		echo ' | ' . sprintf(__('Page %s', 'fuzzco'), max($paged, $page));
  }
endif;

// Modify Page Title
if (!function_exists('fuzzco_title')) :
  function fuzzco_title($title, $sep) {
  	global $paged, $page;
  	if (is_feed())
  		return $title;
  	// Add the site name.
  	$title .= get_bloginfo('name');
  	// Add the site description for the home/front page.
  	$site_description = get_bloginfo('description', 'display');
  	if ($site_description && !is_home() && !is_front_page())
  		$title = "$title $sep $site_description";
  	// Add a page number if necessary.
  	if ($paged >= 2 || $page >= 2)
  		$title = "$title $sep " . sprintf(__('Page %s', 'fuzzco'), max($paged, $page));
  	return $title;
  }
  add_filter('wp_title', 'fuzzco_title', 10, 2);
endif;

// Remove heights and widths from thumbnails for responsive
add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10, 3 );

// Remove heights and widths from inserted images for responsive
add_filter( 'post_thumbnail_html', 'remove_width_attribute', 10 );
add_filter( 'image_send_to_editor', 'remove_width_attribute', 10 );

function remove_width_attribute( $html ) {
   $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
   return $html;
}

// Remove image links from inserted images
function wpb_imagelink_setup() {
	$image_set = get_option( 'image_default_link_type' );
	if ($image_set !== 'none') {
		update_option('image_default_link_type', 'none');
	}
}
add_action('admin_init', 'wpb_imagelink_setup', 10);


/* ---------------------------------------------

Gulp Workflow Modifications

--------------------------------------------- */

// Custom image sizes
// add_image_size('lorem', 2000, 1300, true);
$host = $_SERVER['HTTP_HOST'];
if (strpos($host,'.dev') !== false) {
    // jklb code
    define('GOOGLE_ANALYTICS_ID', 'UA-30048645-2');
} else {
    // Client code
    define('GOOGLE_ANALYTICS_ID', 'UA-xxxxxx-1');
}


/**
 * Fuzzco includes
 *
 * The $fuzzco array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 */
$fuzzco_includes = array(
  'lib/scripts.php',         // Scripts and stylesheets
  'lib/extras.php',          // Custom functions
);

foreach ($fuzzco_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'fuzzco'), $file), E_USER_ERROR);
  }

  require_once $filepath;
}

unset($file, $filepath);


/* ---------------------------------------------

Theme-specific Modifications

--------------------------------------------- */

// Custom image sizes
// add_image_size('lorem', 2000, 1300, true);
