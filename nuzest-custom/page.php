<?php get_header(); ?>

<section class="intro-sec primary-intro">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-10 col-md-offset-1 col-xl-8 col-xl-offset-2">
				<h1><?php the_title(); ?></h1>
			</div>
		</div>
	</div>
</section>

<!-- Page intro -->
<div class="container">
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1 col-xl-8 col-xl-offset-2">
			<?php the_content(); ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>
