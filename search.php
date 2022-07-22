<?php

/**
 * The template for displaying Search Results pages
 *
 * @package WordPress
 * @subpackage Liner_Hu
 * @since Liner Hu 1.0
 */

get_header(); ?>


<section class="tax_section">
	<div class="container">
		<div class="before_ads" id="liner_nyito_fekvo_1">
			<script type="text/javascript">
				activateBanner('liner_nyito_fekvo_1');
			</script>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<h1 class="egy-header-title my-5">
					<?php
					/* translators: %s: Search query. */
					printf(__('Keresési találatok: %s', 'liner'), '<span>' . get_search_query() . '</span>');
					?>
				</h1>
			</div>
			<?php
			$term = $queried_object = get_queried_object();
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;



			$s = (get_query_var('s')) ? get_query_var('s') : 1;
			$args = array(
				'post_type'              	=> 'linernews',
				'post_status'            	=> 'publish',
				'orderby' 					=> 'date',
				'posts_per_page'         	=> 10,
				'paged' 					=> $paged,
				's'         				=> $s
			);

			$the_query = new WP_Query($args);

			$count = $the_query->found_posts;
			$last = '';
			$i = 1;
			$date = '';
			if ($the_query->have_posts()) {
				echo '<div class="col-sm-8 category-wide-section">';

				/* Start the Loop */
				while ($the_query->have_posts()) {
					$the_query->the_post();


					$poplr = get_field('most_popular_news', $the_query->post->ID);
					$brknews = get_field('breaking_news', $the_query->post->ID);

					if ($poplr == 1) {
						$popular = '';
					} else {
						$popular = '';
					}

					if ($brknews == 1) {
						$breaknews = '';
						$popular = '';
					} else {
						$breaknews = '';
					}

					$image_attributes = wp_get_attachment_image_src(get_post_thumbnail_id($the_query->post->ID), 'medium');

					if ($date != get_the_date('Y.m.d')) {
						setlocale(LC_ALL, 'hu_HU.UTF-8');
						$dateTitle = strftime('%A', strtotime(get_the_date('Y/m/d')));
						echo '<div class="d-flex align-items-center justify-content-between mt-4" style="border-bottom: 1px solid #d1d1d1;">
						<h1 class="friss-title egy-header-title mt-0">' . $dateTitle . '</h1>';
						$date = get_the_date('Y.m.d');
						echo '<div class="group-date">' . $date . '</div>';
						echo '</div>';
					}


					?>
					<div class="news-item d-flex <?php echo $poplr || $brknews ? 'align-items-center' : ''; ?>">
						<span class="post-tagline mr-4 font-weight-bold <?php echo $poplr || $brknews ? '' : 'mt-5'; ?>"><?php echo get_post_time('H:i'); ?></span>
						<?php if ($poplr || $brknews) : ?>
							<img src="<?php echo $image_attributes[0] ?>" style="width: 120px;min-height: 70px;object-fit: cover;max-height: 70px;min-width: 120px;max-width: 120px;" class="mr-4" />
						<?php endif; ?>
						<div>
							<p class="post-tagline">
								<?php echo getCategoryByPostIdd($the_query->post->ID); ?>
							</p>
							<div class="news-item-title">

								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</div>
							<?php if (!$poplr && !$brknews) : ?>
								<div class="news-item-content">
									<?php the_excerpt(); ?>
								</div>
							<?php endif; ?>
						</div>
					</div>

				<?php

					}



					$big = 999999999; // need an unlikely integer
					echo '<div class="page-links mt-5">';
					echo paginate_links(array(
						'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
						'format' => '?paged=%#%',
						'current' => max(1, get_query_var('paged')),
						'total' => $the_query->max_num_pages
					));
					echo '</div>';



					echo '</div>';
				} else { ?>
				<div class="col-md-8 col-sm-12 category-wide-section">


					<article id="post-0" class="post no-results not-found">
						<header class="entry-header">
							<h1 class="entry-title"><?php _e('Nothing Found', 'liner'); ?></h1>
						</header>

						<div class="entry-content">
							<p><?php _e('Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'liner'); ?></p>
							<?php get_search_form(); ?>
						</div><!-- .entry-content -->
					</article><!-- #post-0 -->

				</div>



			<?php } ?>

			<div class="col-md-4 col-sm-12 category-wide-sidebar"><?php if (is_active_sidebar('sidebar-5')) : ?><div class="news_sidebar category-sidebar" style="margin-top:12px"><?php dynamic_sidebar('sidebar-5'); ?></div><?php endif; ?>
				<div class="sdbrstcky_post">
					<?php echo do_shortcode('[sidebar-sticky]'); ?>
				</div>
			</div>

		</div>
	</div>
</section>


<?php get_sidebar(); ?>
<?php get_footer(); ?>