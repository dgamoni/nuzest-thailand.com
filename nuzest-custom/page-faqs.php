<?php get_header(); ?>

<!-- Page intro -->
<?php get_template_part( 'inc/content', 'intro' ); ?>

<!-- FAQ Search bar -->
<?php get_template_part( 'inc/block', 'faq-search' ); ?>

<?php
// get all the FAQ topics that have questions assigned to them
$topics = get_terms( 'topics', 'parent=0&hide_empty=1' );
?>
<section class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="row margin-top-lg">
				<?php
				foreach ( $topics as $topic ) {
					echo '<div class="topic-list col-md-6 col-lg-3"><a class="btn btn-square" href="#' . $topic->term_id . '">' . $topic->name . '</a></div>';
				}
				?>
			</div>
		</div>
	</div>
</section>

<section class="container">
	<?php
	// loop through the list of topics
	foreach ( $topics as $topic ):
		$topicID = $topic->term_id;
	?>
	<article class="row main-topic" id="<?php echo $topicID ?>">
		<div class="col-md-8 col-md-offset-2">
			<header class="row"><h1 class="col-md-12"><?php echo $topic->name ?></h1></header>

			<div class="row sub-topic">
				<div class="col-lg-6 quick-list">
					<ul class="list-unstyled faq-list">
						<?php
						$termchildren = get_term_children($topicID, 'topics');
						// loop through and display questions assigned to each top level-topic
						// but not its children
						$args = array(
							'post_type' => 'faqs',
							'tax_query'=>
							array('relation' => 'AND',
					            array( 'taxonomy' => 'topics',
									'field' => 'term_id',
									'terms' => array($topicID),
									'operator' => 'IN'
								),
								array( 'taxonomy' => 'topics',
									'field' => 'term_id',
									'terms' => $termchildren,
									'operator' => 'NOT IN'
								)
						    )
						);
						$wp_query = new WP_Query( $args );
						$question = 0;
						$q_half = ceil($wp_query->found_posts / 2);
						if( $wp_query->have_posts() ) :
							while ( $wp_query->have_posts() ) :
								$wp_query->the_post();
							?>
						<li>
							<h4><?php the_title(); ?></h4>
							<div class="detail"><?php the_field( 'answer' ); ?>
								<?php if( have_rows('more_info') ): ?>
								<p><em>More info:</em><br>
								<?php while( have_rows('more_info') ):
									the_row(); $postobject = get_sub_field('link'); ?>
								<a href="/?p=<?php echo $postobject->ID; ?>"><?php echo $postobject->post_title; ?></a></p>
								<?php
									endwhile;
									endif; ?>
							</div>
							<p class="quick-arrow"></p>
							<hr>
						</li>

						<?php if ( ++$question  == $q_half ) : ?>
					</ul>
				</div>
				<div class="col-lg-6 quick-list">
					<ul class="list-unstyled faq-list">
						<?php endif; ?>

						<?php
							endwhile;
								endif;
							wp_reset_query(); ?>
					</ul>
				</div>
			</div>

			<?php
			// loop through and display list of sub-topics assigned to that topic
			$subs = get_terms( 'topics', array(
				'parent' => $topicID,
				'hide_empty' => 1
				));

			foreach ( $subs as $sub ) :
				$subID = $sub->term_id;
			?>
			<div class="row sub-topic">
				<h2 class="col-md-12"><?php echo $sub->name ?></h2>
				<div class="col-lg-6 quick-list">
					<ul class="list-unstyled faq-list">
						<?php
						// loop through and display questions assigned to ecach sub-topic
						$args = array(
							'post_type' => 'faqs',
							'tax_query' => array(
								array(
									'taxonomy' => 'topics',
									'field'    => 'term_id',
									'terms'    => $subID,
									)	) );
						$wp_query = new WP_Query( $args );
						$question = 0;
						$q_half = ceil($wp_query->found_posts / 2);
						if( $wp_query->have_posts() ) :
							while ( $wp_query->have_posts() ) :
								$wp_query->the_post();
							?>
						<li>
							<h4><?php the_title(); ?></h4>
							<div class="detail"><?php the_field( 'answer' ); ?>
								<?php if( have_rows('more_info') ): ?>
								<p><em>More info:</em><br>
								<?php while( have_rows('more_info') ):
									the_row(); $postobject = get_sub_field('link'); ?>
								<a href="/?p=<?php echo $postobject->ID; ?>"><?php echo $postobject->post_title; ?></a></p>
								<?php
									endwhile;
									endif; ?>
							</div>
							<p class="quick-arrow"></p>
							<hr>
						</li>

						<?php if ( ++$question  == $q_half ) : ?>
					</ul>
				</div>
				<div class="col-lg-6 quick-list">
					<ul class="list-unstyled faq-list">
						<?php endif; ?>

						<?php
							endwhile;
								endif;
							wp_reset_query(); ?>
					</ul>
				</div>
			</div>
			<?php endforeach; ?>
	</article>
	<?php endforeach; ?>
</section>


		<?php get_footer(); ?>
