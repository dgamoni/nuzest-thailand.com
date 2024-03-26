<?php
/* Schema.org Publisher information */
?>

<div class="schema-publisher" itemtype="https://schema.org/Organization" itemscope="itemscope" itemprop="publisher">
	<link itemprop="url" href="<?php echo get_template_directory_uri(); ?>"> 
	<link itemprop="name"><?php bloginfo('name'); ?></link>
	<span itemprop="logo" itemscope="" itemtype="https://schema.org/ImageObject">
		<link itemprop="url" href="<?php echo get_template_directory_uri().'/images/nuzest-logo.png'; ?>">
		<meta itemprop="width" content="155">
	</span>
</div>