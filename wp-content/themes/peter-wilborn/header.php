<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="description" content="<?php fuzzco_description(); ?>" />
    <meta name="keywords" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- 
    Social tags taken from Facebook guidelines: 
    https://developers.facebook.com/docs/sharing/best-practices
    -->
    <?php if (is_front_page()) : ?>
      <meta property="og:title" content="<?php bloginfo('title'); ?>" />
    <?php else : ?>
      <meta property="og:title" content="<?php echo get_the_title(); ?> | <?php bloginfo('title'); ?>" />
    <?php endif; ?>
    <meta property="og:site_name" content="<?php bloginfo('name'); ?>" />
    <meta property="og:description" content="<?php echo get_bloginfo('description', 'display') ?>" />
    <meta property="og:url" content="<?php echo get_permalink($post->ID) ?>" />
    <!-- Recommended logo size is 1200 x 630px -->
    <meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/-/img/logo.png" />

    <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/-/img/favicon.ico"/>
    <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('title'); ?> Feed" href="<?php echo get_bloginfo('rss2_url') ?>" />
    <link href='https://fonts.googleapis.com/css?family=Federo' rel='stylesheet' type='text/css'>
    
    <!--[if lt IE 9]><script src="<?php echo get_template_directory_uri(); ?>/-/js/html5.js"></script><![endif]-->
    <?php wp_head(); ?>
    
  </head>
<body <?php body_class(); ?>>
<div class="container">
	<header>
		<div class="row">
			<div class="inner">
				<div class="col8">
					<h1 class="header__title" id="no-left-margin">THE LAW OFFICE OF PETER WILBORN</h1>
				</div>
				<div class="col4">
					<img class="header__logo" src="/wp-content/themes/peter-wilborn/img/logo.png">
				</div>
			</div>
		</div>
		<div class="row">
			<div id="border-1"></div>
		</div>
		<div class="row">
			<div id="border-2"></div>
		</div>
<!--
		<div class="content inner">
			<div class="row">
				<div class="col8">
					<h2 class="content__title">Vivamus sagittis lacus vel augue.</h2>
				</div>
			</div>
		</div>
-->
	</header>
</div>
