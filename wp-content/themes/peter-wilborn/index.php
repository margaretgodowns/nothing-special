<?php get_header(); ?>
<?php if (have_posts()) while (have_posts()) : the_post(); ?>

  <div id="content" class="inner">
	<?php the_title(); ?>
	<?php the_content(); ?>
  </div>

<?php endwhile; ?>
<?php get_footer(); ?>
