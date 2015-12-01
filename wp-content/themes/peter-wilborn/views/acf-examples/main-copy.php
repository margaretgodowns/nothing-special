<?php
// ACF EXAMPLE - Grabs a repeater
// ----------------------------------
if(have_rows('main_section')) {
  while ( have_rows('main_section') ) : the_row(); ?>
    <section class="main-copy">
      <div class="row align-middle">
	<div class="col12">
	  <h1><?php echo get_sub_field('main_section_title') ?></h1>
	  <?php echo get_sub_field('main_section_copy'); ?>
	</div>
      </div>
    </section>
  <?php endwhile;
}
