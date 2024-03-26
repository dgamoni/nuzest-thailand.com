<?php
	/*
	Template Name: Blog Page Template
	*/

	wp_enqueue_script('underscore', null, null, null, true);
	wp_enqueue_script('underscore-mixins', get_template_directory_uri().'/js/common/_.mixins.js', array('underscore'), '', true);
	wp_enqueue_script('angular', '//ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js', array('jquery'), '', true);
	wp_enqueue_script('angular-sanitize', '//ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular-sanitize.min.js', array('angular'), '', true);
	wp_enqueue_script('angular-animate', '//ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular-animate.min.js', array('angular'), '', true);
	wp_enqueue_script('angular-paginate', get_template_directory_uri().'/js/common/angularPagination.js', array('angular'), '', true);
	wp_enqueue_script('angular-truncate', get_template_directory_uri().'/js/common/truncate.js', array('angular'), '', true);
	wp_enqueue_script('angular-wp-taxonomy', get_template_directory_uri().'/js/common/services/angularWPTaxonomy.js', array('angular'), '', true);
	wp_enqueue_script('angular-wp-posts', get_template_directory_uri().'/js/common/services/angularWPPosts.js', array('angular','angular-paginate'), '', true);
	wp_enqueue_script('angular-wp-blogpost', get_template_directory_uri().'/js/common/services/angularWPBlogpost.js', array('angular','angular-wp-posts'), '', true);
	wp_enqueue_script('angular-wp-author', get_template_directory_uri().'/js/common/services/angularWPAuthor.js', array('angular','angular-wp-posts'), '', true);
	wp_enqueue_script('blog_js', get_template_directory_uri().'/js/blog/blog.js', array(
		'angular','angular-sanitize','angular-animate',
		'angular-wp-taxonomy', 'angular-wp-blogpost', 'angular-wp-author',
		'underscore-mixins'), '', true);

	// Get all blog authors for js filtering
	$authors = array();
	$users = nz_get_blog_authors();
	foreach ($users as $user)
	{
		$authors[] = array(
			'slug' => $user->ID,
			'name' => $user->data->display_name
		);
	}
	// Sort the authors by display name
	usort($authors, function($a,$b) {
		return strcmp($a['name'], $b['name']);
	});
	$authors = array_reverse($authors);
	//json encode for js
	$authors = json_encode($authors);

	$page_title = get_field('page_title');
	$page_intro = get_field('page_intro');

	$banner_query = new WP_Query( array(
			'post_type' => 'banners',
			'meta_key' => 'location',
			'meta_value' => 'blog',
			'posts_per_page' => 1,
	));

	get_header();
?>

<?php if ( $banner_query -> have_posts() ) : while ( $banner_query -> have_posts() ) : $banner_query -> the_post(); ?>
<section id="feature-banner" class="feature-banner-blog">
	<div class="container banner-container">
    	<?php if( have_rows( 'small_banners' ) ): ?>
			<div class="row royalSlider rsDefault">
			<?php while ( have_rows( 'small_banners' ) ) : the_row(); ?>

				<?php
				if( get_sub_field( 'active' )) :
					$banner_image = get_sub_field( 'banner_image' );
					//lookup details from post this banner is linked to
					$bnpost = get_sub_field('post_link');
					//setup_postdata( $bnpost );
					if ( ( get_sub_field( 'get_post_content' ) == 'post' ) ) {
						$banner_title = get_the_title( $bnpost->ID );
						$excerpt = get_the_excerpt( $bnpost->ID );
					} else {
						$banner_title = get_sub_field( 'banner_heading' );
						$excerpt = get_sub_field( 'banner_content' );
					};
					$trimmed_excerpt = wp_trim_words( $excerpt, $num_words = 18);
					$link = post_permalink(  $bnpost->ID  );
					$authID = $bnpost->post_author;
					$authName = get_the_author_meta( 'display_name', $authID );
					$authByline = get_field( 'byline', 'user_' . $authID );
					$authBio = get_field( 'short_bio', 'user_' . $authID );
					$authPhoto = get_field( 'photo', 'user_' . $authID );
					$authURL = get_author_posts_url( $authID );
				?>
                <div class="rsContent">
                    <div class="col-sm-7 col-md-8 col-xl-9 banner-img">
                            <div class="post-image" style="background-image: url('<?php echo $banner_image['url']; ?>');"></div>
                    </div>
                    <div class="col-sm-5 col-md-4 col-xl-3 banner-info">
                        <h2><?php echo $banner_title ?></h2>

                        <p class="hidden-xs hidden-sm hidden-md"><?php echo($excerpt); ?></p>
                        <p class="hidden-xs hidden-sm visible-md hidden-lg"><?php echo($trimmed_excerpt); ?></p>

                        <div class="banner-footer">
                            <a class="btn btn-primary" href="<?php echo $link ?>"><?php _e('Read More', 'nuzest-custom') ?></a>
                        </div>

                        <div class="author-banner">
                            <div class="img-circle img-profile"
                                <?php if ($authPhoto): ?>
                                    style="background-image: url(<?php echo $authPhoto['url']; ?>);"
                                <?php endif; ?>
                                >
                            </div>
                            <p class="authName"><?php echo $authName; ?></p>
                            <p class="authByline"><?php echo $authByline; ?></p>
                        </div>
                    </div>
                </div>
		<?php endif; endwhile; ?>
        </div>
        <?php endif; ?>
	</div>
</section>
<?php endwhile; endif; wp_reset_postdata(); // end banner loop ?>


<script type="text/javascript">
	var blogpostSearchApp = {
		authors : <?php echo $authors ?>
	}
</script>

<section ng-app="blogpostSearchApp" class="overflow-visible">
	<div class="container">
		<div class="row section-header">
			<div class="col-md-12">
				<h1><?php echo $page_title ?></h1>
				<?php echo $page_intro ?>
			</div>
		</div>
		<div class="row margin-bottom-md" ng-controller="SearchArea as searchArea">
			<div class="col-md-3">
				<div class="filter-controller activeToggle">
					<h3>
						<?php _e('Author:', 'nuzest-custom') ?>
						<span ng-if="searchArea.selected.author.length<1"><?php _e('All', 'nuzest-custom') ?></span>
						<span ng-if="searchArea.selected.author.length===1" ng-bind-html="searchArea.selected.author[0]"></span>
						<span ng-if="searchArea.selected.author.length>1"><?php _e('Multiple', 'nuzest-custom') ?></span>
					</h3>
					<ul>
						<li ng-repeat="author in searchArea.authors">
							<span class="checkbox">
								<input type="checkbox" name="{{author.slug}}" id="{{author.slug}}" value="{{author.slug}}" ng-model="searchArea.filters.author[author.slug]">
								<label for="{{author.slug}}" ng-bind-html="author.name"></label>
							</span>
						</li>
					</ul>
				</div>
			</div>
			<div class="col-md-3">
				<div class="filter-controller activeToggle">
					<h3>
						<?php _e('Category:', 'nuzest-custom') ?>
						<span ng-if="searchArea.selected.category.length<1"><?php _e('All', 'nuzest-custom') ?></span>
						<span ng-if="searchArea.selected.category.length===1" ng-bind-html="searchArea.selected.category[0]"></span>
						<span ng-if="searchArea.selected.category.length>1"><?php _e('Multiple', 'nuzest-custom') ?></span>
					</h3>
					<ul>
						<li ng-repeat="category in searchArea.taxonomies.category">
							<span class="checkbox">
								<input type="checkbox" name="{{category.slug}}" id="{{category.slug}}" value="{{category.slug}}" ng-model="searchArea.filters.category[category.slug]">
								<label for="{{category.slug}}" ng-bind-html="category.name"></label>
							</span>
						</li>
					</ul>
				</div>
			</div>
			<div class="col-md-3">
				<div class="filter-controller activeToggle">
					<h3>
						<?php _e('Date:', 'nuzest-custom') ?>
						<span ng-if="searchArea.order==='asc'"><?php _e('Ascending', 'nuzest-custom') ?></span>
						<span ng-if="searchArea.order==='desc'"><?php _e('Descending', 'nuzest-custom') ?></span>
					</h3>
					<ul>
						<li>
							<span class="radio">
								<input type="radio" name="order_asc" id="order_asc" value="asc" ng-model="searchArea.order">
								<label for="order_asc"><?php _e('Ascending', 'nuzest-custom') ?></label>
							</span>
						</li>
						<li>
							<span class="radio">
								<input type="radio" name="order_desc" id="order_desc" value="desc" ng-model="searchArea.order">
								<label for="order_desc"><?php _e('Descending', 'nuzest-custom') ?></label>
							</span>
						</li>

					</ul>
				</div>

			</div>

			<div class="col-md-3">
				<div class="field-icon">
					<input ng-model="searchArea.filters.search" maxlength="150" type="text" class="txt" placeholder="Search" />
					<button ng-click="searchArea.search()" id="searchsubmit" class="btn"><span class="glyphicon glyphicon-search"></span></button>
				</div>

			</div>
		</div>

		<div class="snippets">
			<div class="container-fluid">
				<div class="row" ng-controller="PostList as postList">
					<div class="col-sm-6 col-md-4 col-lg-3 blog" ng-repeat="post in postList.posts">
						<article class="snippet">
		                    <a target="_self" href="{{post.link}}"  oonclick="location.reload()" title="{{post.title}}" class="snippet-image">
		                        <img class="img-responsive" width="100%" ng-src="{{post.featured_image.source}}" alt="{{post.title}}">
		                    </a>

							<div class="author-info">
									<div class="img-circle img-profile"
										alt="{{post.author.name}}"
										ng-style="{'background-image': 'url( {{post.author.meta.photo.sizes.thumbnail}} )'}">
										<a ng-href="/profiles/{{post.author.slug}}" class="blockLink"></a>
									</div>
								<p class="authName">{{post.author.name}}</p>
								<p class="authByline hidden-xs hidden-sm">{{post.author.meta.byline}}</p>
							</div>

							<div class="info">
								<h5 class="title"><a target="_self" href="{{post.link}}"  oonclick="location.reload()" ng-bind-html="post.title"></a></h5>
								<p ng-bind-html="post.excerpt | words:24"></p>
							</div>

							<a class="btn btn-primary" target="_self" href="{{post.link}}" oonclick="location.reload()"><?php _e('View', 'nuzest-custom') ?></a>
						</article>
					</div>
					<div class="col-xs-12 text-center" ng-if="postList.loading"><h2><?php _e('Loading', 'nuzest-custom') ?>&hellip;</h2></div>
					<div class="col-xs-12 text-center" ng-if="postList.noResults()"><h2><?php _e('Sorry, no results found, please try a different search', 'nuzest-custom') ?></h2></div>
				</div>
			</div>
		</div>

		<div class="row row-pagination" ng-controller="PostPagination as postPagination">
			<div class="pagination">
				<ul>
					<li class="arrow arrow-left" ng-if="postPagination.pagination.hasPrevPage()"><a ng-click="postPagination.pagination.prevPage()"></a></li>
					<li ng-repeat="page in postPagination.pages track by $index" ng-class="{active: page===postPagination.pagination.currentPage}">
						<a ng-click="postPagination.pagination.setPage(page)">{{page}}</a>
					</li>
					<li class="arrow arrow-right" ng-if="postPagination.pagination.hasNextPage()"><a ng-click="postPagination.pagination.nextPage()"></a></li>
				</ul>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
