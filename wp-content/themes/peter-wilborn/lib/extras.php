<?php
/**
 * Custom functions, all this is optional
 * Mosly cleaning up the admin interface.
 * Comment out what you don't need, and uncomment what you want.
 */


//
// Removes Types (custom post type generator) marketing
//
//////////////////////////////////////////////////////////////////////

function adminstyle() {
  echo
    '<style type="text/css">
      #wpcf-marketing { display: none;}
      .cp-rss-widget { display: none; }
    </style>';
}
add_action('admin_head', 'adminstyle');



