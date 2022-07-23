<?php

/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Liner Hu already
 * has tag.php for Tag archives, category.php for Category archives, and
 * author.php for Author archives.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Liner_Hu
 * @since Liner Hu 1.0
 */

get_header();

function getCategoryOrSub($id)
{
	$categories = wp_get_post_terms($id, 'news_cat', array('fields' => 'all'));
	$parentCategory = '';
	$childCategory = '';
	$parentLink = '';
	$childLink = '';
	foreach ($categories as $category) {
		if ($category->parent == 0) {
			$parentCategory = $category->name;
			$parentCategory = str_replace('#', '', $parentCategory);
			$parentLink = get_term_link($category->slug, 'news_cat');
		}
		if ($category->parent != 0) {
			$childCategory = $category->name;
			$childCategory = str_replace('#', '', $childCategory);
			$childLink = get_term_link($category->slug, 'news_cat');
		}
	}


	if ($childCategory != '') {
		$output = '<a href="' . $childLink . '" class="tag-slug mr-2 mb-1">' . $childCategory . '</a>';
	} else {
		$output = '<a href="' . $parentLink . '" class="tag-slug mr-2 mb-1">' . $parentCategory . '</a>';
	}
	return $output;
}
$term = $queried_object = get_queried_object();
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
	'post_type'              => 'linernews',
	'post_status'            => 'publish',
	'posts_per_page'         => 5,
	'paged' 				=>	 $paged,
	'tax_query' 			 => array(
		array(
			'taxonomy' 	=> 'news_cat',
			'field'    	=> 'slug',
			'terms'    	=> $term->slug,
		)
	)
);

$the_query = new WP_Query($args);
global $postnot;
?>

<section class="tax_section category-page">
	<div class="container">
		<div class="before_ads mb-5" id="liner_nyito_fekvo_1">
			<script type="text/javascript">
				activateBanner('liner_nyito_fekvo_1');
			</script>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<?php
				if ($the_query->have_posts()) :
					$i = 1;
					while ($the_query->have_posts()) :
						$the_query->the_post();
						$excpt = $the_query->post->post_excerpt;
						$ttln = $the_query->post->post_title;
						$poplr = get_field('most_popular_news', $the_query->post->ID);
						$brknews = get_field('breaking_news', $the_query->post->ID);

						if ($poplr == 1) {
							$popular = ' post-background-green';
						} else {
							$popular = '';
						}

						if ($brknews == 1) {
							$breaknews = ' post-background-yellow';
							$popular = '';
						} else {
							$breaknews = '';
						}
						if ($i == 1) : ?>
							<section class="full desktop-only mb-5">
								<div class="immersive-break-2 d-lg-flex align-items-center">
									<div class="w-50 h-100 image-part">
										<img src="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id($the_query->post->ID), 'medium_large')[0] ?>" alt="" style="width:100%;height:100%;object-fit:cover;">
									</div>
									<div class="w-50 p-5 text-part">
										<h1 class="mb-4 post-title" style="font-size:32px;">
											<a href="<?php echo get_the_permalink($the_query->post->ID) ?>" class="title-slug">
												<?php echo $ttln ?>
											</a>
										</h1>
										<p class="post-description text-white"><?php echo $excpt ?></p>
										<!-- <a href="' . $link . '" class="tovabb-btn-2">Tovább</a> -->
									</div>
								</div>
							</section>
						<?php endif;
								if ($i == 2) : echo '<div class="row">';
								endif;
								if ($i > 1 && $i <= 5) : ?>
							<div class="mb-4 col-12 col-lg-3 d-flex flex-column justify-content-between">
								<div class="h-100" style="padding:0 !important;">
									<div>
										<img class="w-100 mob-image3" src="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id($the_query->post->ID), 'medium_large')[0] ?>">
									</div>
									<div class=" <?php echo $popular . $breaknews ?>">
										<div>
											<p class="post-tagline">
												<?php echo getCategoryOrSub($the_query->post->ID) ?>
												<span>|</span>
												<span><?php echo get_post_time('H:i') ?></span>
											</p>
										</div>
										<h2 class="post-title post-title2">
											<a class="title-slug" href="<?php echo get_the_permalink($the_query->post->ID) ?>">
												<?php echo $ttln ?>
											</a></h2>
										<p class="post-description section1-description">
											<?php echo $excpt ?>
										</p>
									</div>
								</div>
							</div>
						<?php endif; ?>
						<?php if ($i == 5) : echo '</div>';
								endif; ?>
				<?php
						$postnot[] = $the_query->post->ID;
						$i++;
					endwhile;
					wp_reset_postdata();
				endif;
				?>
			</div>
			<div class="col-lg-8 category-wide-section">
				<?php
				$args = array(
					'post_type'              => 'linernews',
					'post_status'            => 'publish',
					'posts_per_page'         => 10,
					'post__not_in'           => $postnot,
					'paged' 				=>	 $paged,
					'tax_query' 			 => array(
						array(
							'taxonomy' 	=> 'news_cat',
							'field'    	=> 'slug',
							'terms'    	=> $term->slug,
						)
					)
				);

				$the_query = new WP_Query($args);
				if ($the_query->have_posts()) {
					echo '<h2 class="egy-header-title single text-uppercase">További Hírek</h2>';
					/* Start the Loop */
					while ($the_query->have_posts()) {
						$the_query->the_post();

						$excpt = $the_query->post->post_excerpt;


						$image_attribute = wp_get_attachment_image_src(get_post_thumbnail_id($the_query->post->ID), 'medium_large');


						$ttln = $the_query->post->post_title;

						$poplr = get_field('most_popular_news', $the_query->post->ID);
						$brknews = get_field('breaking_news', $the_query->post->ID);

						if ($poplr == 1) {
							$popular = ' post-background-green d-flex flex-column justify-content-center w-100';
						} else {
							$popular = '';
						}

						if ($brknews == 1) {
							$breaknews = ' post-background-yellow d-flex flex-column justify-content-center w-100';
							$popular = '';
						} else {
							$breaknews = '';
						}

						if ($brknews == 1 || $poplr == 1) {
							$normal = '';
						} else {
							$normal = 'ml-4';
						}
						?>

						<div class="cat-article-card mt-5">
							<div class="">
								<img class="w-100" src="<?php echo $image_attribute[0]; ?>">
							</div>
							<div class="<?php echo $popular . $breaknews . $normal; ?>">
								<div>
									<p class="post-tagline">
										<?php echo getCategoryOrSub($the_query->post->ID) ?>
										<span>|</span>
										<span><?php echo get_post_time('H:i') ?></span>
									</p>
								</div>
								<h2 class="post-title post-title1">
									<a class="title-slug" href="<?php echo get_the_permalink($the_query->post->ID) ?>">
										<?php echo $ttln ?>
									</a></h2>
								<p class="post-description section1-description mb-0">
									<?php echo $excpt ?>
								</p>
							</div>
						</div>

				<?php $postnot[] = $the_query->post->ID;
						$i++;
					}

					if (count($sub_categories) < 1) :
						$big = 999999999; // need an unlikely integer
						echo '<div class="text-center mt-5">';
						echo '<div class="page-links page cat aut">';
						echo paginate_links(array(
							'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
							'format' => '?paged=%#%',
							'current' => max(1, get_query_var('paged')),
							'total' => $the_query->max_num_pages
						));
						echo '</div>';
						echo '</div>';
					endif;
					echo '</div>';
				} ?>
				<div class="col-lg-4 col-sm-12 category-wide-sidebar">

					<div class="news_sidebar category-sidebar">

						<?php
						$output = '';
						$ttln = '';



						// The Loop
						$posts = PVC_GET_MOST_VIEWED_POSTS(array(
							'post_type'              => 'linernews',
							'post_status'            => 'publish',
							'posts_per_page'         => 5,
							// 'post__not_in'           => $postnot,
							'tax_query' 			 => array(
								array(
									'taxonomy' 	=> 'news_cat',
									'field'    	=> 'slug',
									'terms'    	=> $term->slug,
								)
							),
							// today_date = date('Y-m-d');
							'date_query' => array(
								array(
									'after' => '1 day ago',
									// 'before' => 'today',
									'inclusive' => true,
								),
							),

						));

						if ($posts) {
							$output .= '<div class="justin_single" style="padding-top: 30px;margin-top: 40px;">
								<h3 class="text-uppercase category-sidebar-title egy-header-title">Top ' . count($posts) . '/24</h3>
								<div class="sidebar-img">
									<img src="' . get_template_directory_uri() . '/images/24_liner.png" class="img-responsive">
								</div>
								<ul>';
							foreach ($posts as $post) {

								$ttln = $post->post_title;
								$poplr = get_field('most_popular_news', $post->ID);
								$brknews = get_field('breaking_news', $post->ID);

								if ($poplr == 1) {
									$popular = 'fontos';
								} else {
									$popular = '';
								}

								if ($brknews == 1) {
									$breaknews = 'fontos';
									$popular = '';
								} else {
									$breaknews = '';
								}

								$output .= '<li>          
								  <span>
								  
									<span>' . get_post_time('H:i') .  '</span>
									';
								if ($poplr == 1 || $brknews == 1) {
									$output .= '<img class="fontos-img" src="' . get_bloginfo("template_url") . '/images/fontos.png" style="width:15px" />';
								}
								$output .= '            
								  </span>
								  <h6>
									<a href="' . get_the_permalink($post->ID) . '">' . $ttln . '</a>
								  </h6>
								</li>';
							}
							$output .= '</ul></div>';
						}

						// Restore original Post Data
						echo $output;

						?>
					</div>
					<div class="sdbrstcky_post">
						<?php echo do_shortcode('[sidebar-sticky]'); ?>
					</div>
					<div>
						<!-- <img src="<?php echo get_template_directory_uri() ?>/images/300x600.jpeg" alt="ads" class="img-fluid w-100" style="max-width: 100%;max-height: 600px;object-fit: cover;"> -->
						<div class="siderbar_ads1" id="liner_cikk_jobb_1">
							<script type="text/javascript">
								activateBanner(''liner_cikk_jobb_1'');
							</script>
						</div>
					</div>
					<div class="mt-4">
						<div class="siderbar_ads2" id="liner_cikk_jobb_2">
							<script type="text/javascript">
								activateBanner('liner_cikk_jobb_2');
							</script>
						</div>
						<!-- <img src="<?php echo get_template_directory_uri() ?>/images/300x600.jpeg" alt="ads" class="img-fluid w-100" style="max-width: 100%;max-height: 600px;object-fit: cover;"> -->
					</div>
				</div>
			</div>
		</div>
</section>

<?php get_footer(); ?>