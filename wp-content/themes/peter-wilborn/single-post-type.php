<?php get_header(); ?>
<?php if (have_posts()) while (have_posts()) : the_post(); ?>

	<div id="content">
		<?php include('views/main-copy') ?>
		<?php include('views/overview') ?>
	</div>

<?php endwhile; ?>
<?php get_footer(); ?>
