<?php
// ACF EXAMPLE - Grabs a repeater and
// a gallery inside it
// ----------------------------------
if(have_rows('overview')) {
  while ( have_rows('overview') ) : the_row(); ?>
    <section class="overview">
      <div class="row">
	<div class="col12">
	  <h1><?php echo get_sub_field('section_title'); ?></h1>
	</div>
      </div>
      <?php if( get_sub_field('overview_gallery') ) { ?>
	<div class="row align-middle center">
	  <?php foreach( get_sub_field('overview_gallery') as $image ): ?>
	    <div class="col4">
	      <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
	      <h3 class="orange"><?php echo $image['title']; ?></h3>
	      <h3><?php echo $image['caption']; ?></h3>
	    </div>
	  <?php endforeach; ?>
	</div>
      <?php } ?>
    </section>
  <?php endwhile; // End while overview
}  // End if overview
